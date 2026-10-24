<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Company;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class CompanyController extends AbstractController
{
    // Route to create a new company for a given user id
    #[Route('/add/company/{id}', name: 'company_new', methods: 'POST')]
    public function new(Request $request, int $id): Response
    {
        $data = json_decode($request->getContent(), true);
        $company = new Company();
        $company->setSiret($data["siret"]);
        $company->setNameCompany($data["nameCompany"]);

        $user = $this->getDoctrine()->getRepository(User::class)->find($id)->where('role', 'PROFESSIONAL');
        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        $company->setUser($user);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($company);
        $entityManager->flush();

        return $this->json(['id' => $company->getId()]);
    }
    // Route for retriving a company by user id
    #[Route('/company/{id}', name: 'company_show', methods: 'GET')]
    public function show(int $id): Response
    {
        $company = $this->getDoctrine()->getRepository(Company::class)->findOneBy(['user' => $id]);

        if (!$company) {
            throw $this->createNotFoundException('Company not found');
        }

        return $this->json([
            'id' => $company->getId(),
            'siret' => $company->getSiret(),
            'nameCompany' => $company->getNameCompany(),
        ]);
    }
    // Route to update a company by id
    #[Route('/company/{id}', name: 'company_update', methods: 'PUT')]
    public function update(Request $request, int $id): Response
    {
        $data = json_decode($request->getContent(), true);
        $entityManager = $this->getDoctrine()->getManager();
        $company = $entityManager->getRepository(Company::class)->find($id);

        if (!$company) {
            throw $this->createNotFoundException('Company not found');
        }

        $company->setSiret($data["siret"]);
        $company->setNameCompany($data["nameCompany"]);

        $entityManager->flush();

        return $this->json(['response' => 'ok']);
    }
}
