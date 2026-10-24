<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class SecurityController extends AbstractController
{
    private $jwtManager;

    private $userRepository;
    private $passwordHasher;


    public function __construct(
        UserRepository $userRepository,
        UserPasswordHasherInterface $passwordHasher,
        JWTTokenManagerInterface $jwtManager,
        private EntityManagerInterface $entityManagerInterface
    ) {
        $this->userRepository = $userRepository;
        $this->passwordHasher = $passwordHasher;
        $this->jwtManager = $jwtManager;
        $this->entityManagerInterface = $entityManagerInterface;
        
    }

    #[Route('/api/login_check', name: 'api_login_check', methods: ['POST'])]

    public function login(Request $request): JsonResponse
    {
        // Fetch raw content from the request
        $rawContent = $request->getContent();
        $data = json_decode($rawContent, true);
       

        // Check if JSON is valid
        if (json_last_error() !== JSON_ERROR_NONE) {
            return new JsonResponse(['message' => 'Invalid JSON'], JsonResponse::HTTP_BAD_REQUEST);
        }

    // Extract username and password from the decoded JSON
        $username = $data['username'] ?? null; // Email is considered as username
        $password = $data['password'] ?? null;
        // dd($username, $password);

    // Check if username and password are provided
        if (!$username || !$password) {
            return new JsonResponse(['message' => 'Email and password are required'], JsonResponse::HTTP_BAD_REQUEST);
        }

    // Validate user credentials
        $user = $this->validateUserCredentials($username, $password);
        if (!$user instanceof UserInterface) {
            return new JsonResponse(['message' => 'Invalid credentials'], JsonResponse::HTTP_UNAUTHORIZED);
        }
        var_dump($user);
        // Generate JWT token
        try {
               
            $token = $this->jwtManager->create($user);
           
            if (empty($token)) {
                throw new \Exception('Token generation failed: empty token returned.');
            }
            return new JsonResponse(['token' => $token]);
        } catch (\Exception $e) {
            // Log the exception message
            error_log('Token generation error: ' . $e->getMessage());
            // Return an error response
            return new JsonResponse(['message' => 'Token generation failed'], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
        // Return the token in a JSON response
        // return new JsonResponse(['token' => $token]);
    }

    public function validateUserCredentials(string $email, string $password): ?UserInterface
{
    
    // Use the entityManager to find the user by email
    $user = $this->entityManagerInterface->getRepository(User::class)->findOneBy(['email' => $email]);

    // Check if the user exists and the password is valid
    if ($user && $this->passwordHasher->isPasswordValid($user, $password)) {
        return $user; // Return the user if credentials are valid
    }

    // Return null if the credentials are invalid
    return null;
}


    #[Route(path: '/api/register', name: 'api_register', methods: ['POST'])]
    public function register(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);  
        if (!isset($data['username']) || !isset($data['password'])) {
            return new JsonResponse(['error' => 'Invalid data'], Response::HTTP_BAD_REQUEST);
        }

        $user = new User();
        $user->setEmail($data['username']);
        $user->setPassword($this->passwordHasher->hashPassword($user, $data['password']));
        $user->setRoles(['ROLE_USER']); 
    
        $entityManager = $this->entityManagerInterface->getRepository(User::class);
        $this->entityManagerInterface->persist($user);
        $this->entityManagerInterface->flush();

        return new JsonResponse(['message' => 'User created'], Response::HTTP_CREATED);
    }

}
