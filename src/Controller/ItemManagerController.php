<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\ItemManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ItemManagerController extends AbstractController
{
    // Route to check if item manager exists for a given id
    #[Route('/check/item-manager/user/{id}/type/{type}', name: 'check_item_manager')]
    public function index(int $id, string $type): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $itemManagerRepository = $entityManager->getRepository(ItemManager::class);
        $itemManager = $itemManagerRepository->find($id);
        if (!$itemManager) {
            return $this->json([
                'response' => 'Not found',
            ]);
        }
        return $this->json([
            'response' => $itemManager->getId(),
        ]);
    }
    // Route to retrive the id of the item manager for a given user based on the user id for a given type
    #[Route('/get/item-manager/user/{id}/type/{type}', name: 'get_item_manager')]
    public function getItemManager(int $userId, string $type): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $itemManagerRepository = $entityManager->getRepository(ItemManager::class);
        $itemManager = $itemManagerRepository->findOneBy(['user' => $userId, 'typeItemManager' => $type]);
        if (!$itemManager) {
            return $this->json([
                'response' => 'Not found',
            ]);
        }
        return $this->json([
            'response' => $itemManager->getId(),
        ]);
    }
    // Route to retrive the type of the item manager for a given id
    #[Route('/get/item-manager/type/{id}', name: 'get_item_manager_type')]
    public function getItemManagerType(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $itemManagerRepository = $entityManager->getRepository(ItemManager::class);
        $itemManager = $itemManagerRepository->find($id);
        if (!$itemManager) {
            return $this->json([
                'response' => 'Not found',
            ]);
        }
        return $this->json([
            'response' => $itemManager->getTypeItemManager(),
        ]);
    }
    // Route to change the type of the item manager for a given id
    #[Route('/change/item-manager/chage-type/{id}/type-after/{type_after}', name: 'change_item_manager_type')]
    public function changeItemManagerType(int $id, string $typeAfter): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $itemManagerRepository = $entityManager->getRepository(ItemManager::class);
        $itemManager = $itemManagerRepository->find($id);
        if (!$itemManager) {
            return $this->json([
                'response' => 'Not found',
            ]);
        }
        $itemManager->setTypeItemManager($typeAfter);
        $entityManager->persist($typeAfter);
        $entityManager->flush();
        return $this->json([
            'response' => 'Ok',
        ]);
    }

    // Route to create a new item manager for a user id for a given type
    #[Route('/create/item-manager/user/{id}/type/{type}', name: 'create_item_manager')]
    public function createItemManager(int $userId, string $type): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $itemManager = new ItemManager();
        $user = $entityManager->getRepository(User::class)->find($userId);
        $itemManager->addUser($user);
        $itemManager->setTypeItemManager($type);
        $entityManager->persist($itemManager);
        $entityManager->flush();
        return $this->json([
            'response' => $itemManager->getId(),
        ]);
    }
    // Route to delete an item manager for a given id
    #[Route('/delete/item-manager/{id}', name: 'delete_item_manager')]
    public function deleteItemManager(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $itemManagerRepository = $entityManager->getRepository(ItemManager::class);
        $itemManager = $itemManagerRepository->find($id);
        if (!$itemManager) {
            return $this->json([
                'response' => 'Not found',
            ]);
        }
        $entityManager->remove($itemManager);
        $entityManager->flush();
        return $this->json([
            'response' => 'Item manager deleted successfully',
        ]);
    }
    // Route to change the quote status of the item manager for a given id
    #[Route('/change/item-manager/quote-status/{id}/status/{status}', name: 'change_item_manager_quote_status')]
    public function changeItemManagerQuoteStatus(int $id, string $status): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $itemManagerRepository = $entityManager->getRepository(ItemManager::class);
        $itemManager = $itemManagerRepository->find($id);
        if (!$itemManager) {
            return $this->json([
                'response' => 'Not found',
            ]);
        }
        $itemManager->setQuoteStatus($status);
        $entityManager->flush();
        return $this->json([
            'response' => 'Ok',
        ]);
    }
}
