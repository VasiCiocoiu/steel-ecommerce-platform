<?php

namespace App\Controller;

use App\Entity\Bill;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class BillController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private Request $request;

    private $security;

    public function __construct(EntityManagerInterface $entityManager, RequestStack $requestStack, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->request = $requestStack->getCurrentRequest();
        $this->security = $security;
    }

    #[Route('api/get/bill', name: 'app_bill')]
    public function getBill(): JsonResponse
    {
       $bill = $this->entityManager->getRepository(Bill::class)->findAll();

       if(!$bill){
           return $this->json(['error' => 'No bill found'], Response::HTTP_NOT_FOUND);
       }

       return $this->json($bill);
    }

    #add bill for current user
    #[Route('api/add/bill', name: 'app_bill_add', methods: ['POST'])]
    public function addBill(): JsonResponse
    {
        $data = json_decode($this->request->getContent(), true);
        $bill = new Bill();
        $bill->setBillNumber($data['bill_number']);
        $bill->setTva($data['tva']);
        $currentUser = $this->security->getUser();
        if (!$currentUser) {
            return $this->json(['error' => 'User not authenticated'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $bill->setClient($currentUser);
        $bill->setBilDate(new \DateTimeImmutable($data['bill_date']));
        $bill->setTotalHTC($data['totalHTC']);
        $bill->setSiret($data['siret']);
        $bill->setCompanyName($data['company_name']);
        $this->entityManager->persist($bill);
        $this->entityManager->flush();

        return $this->json(['id' => $bill->getId()]);

    }

    #retrieve bills by user id
    #[Route('api/get/bill/{id}', name: 'app_bill_get', methods: ['GET'])]
    public function getBillById(int $id): JsonResponse
    {
        $bill = $this->entityManager->getRepository(Bill::class)->findOneBy(['client' => $id]);

        if (!$bill) {
            return $this->json(['error' => 'No bill found'], Response::HTTP_NOT_FOUND);
        }

        return $this->json([
            'id' => $bill->getId(),
            'bill_number' => $bill->getBillNumber(),
            'bill_date' => $bill->getBilDate(),
            'tva' => $bill->getTva(),
            'totalHTC' => $bill->getTotalHTC(),
            'siret' => $bill->getSiret(),
            'company_name' => $bill->getCompanyName()
        ]);
    }

    #update bill by id
    #[Route('api/update/bill/{id}', name: 'app_bill_update', methods: ['PUT'])]
    public function updateBill(int $id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $bill = $this->entityManager->getRepository(Bill::class)->find($id);

        if (!$bill) {
            return $this->json(['error' => 'No bill found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $bill->setBillNumber($data['bill_number']);
        $bill->setTva($data['tva']);
        $bill->setBilDate(new \DateTimeImmutable($data['bill_date']));
        $bill->setTotalHTC($data['totalHTC']);
        $bill->setSiret($data['siret']);
        $bill->setCompanyName($data['company_name']);
        $this->entityManager->flush();

        return $this->json(['response' => 'ok']);
    }

}
