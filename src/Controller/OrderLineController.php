<?php

namespace App\Controller;

use App\Entity\Dimension;
use App\Entity\ItemManager;
use App\Entity\OrderLine;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class OrderLineController extends AbstractController
{
    // Route for adding an order line recived as a JSON to an ItemManager using the id of the ItemManager
    #[Route('/orderline/add/itemManager/{itemId}/dimension/{dimensionId}', name: 'orderline_add', methods: ['POST'])]
    public function addOrderLine(Request $request, int $itemId, int $dimensionId): Response
    {
        $data = json_decode($request->getContent(), true);
        $itemManager = $this->getDoctrine()->getRepository(ItemManager::class)->find($itemId);
        if (!$itemManager) {
            throw $this->createNotFoundException('ItemManager Not found ' . $itemId);
        }
        $dimension = $this->getDoctrine()->getRepository(Dimension::class)->find($dimensionId);
        if (!$dimension) {
            throw $this->createNotFoundException('Dimension Not found ' . $dimensionId);
        }
        $orderLine = new OrderLine();
        $orderLine->setQuantity($data['quantity']);
        $orderLine->setCutLength($data['cutLength']);
        $orderLine->setCutPrice($data['cutPrice']);
        $orderLine->setDiscount($data['discount']);
        $orderLine->addItemManager($itemManager);
        $orderLine->addDimension($dimension);
        $this->getDoctrine()->getManager()->flush();
        return $this->json(['id' => $orderLine->getId()]);
    }
    // Route to retrive the id of the order line for a given item manager id
    #[Route('/get/orderline/itemManager/{id}', name: 'get_orderline')]
    public function getOrderLine(int $itemId): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $orderLineRepository = $entityManager->getRepository(OrderLine::class);
        $orderLine = $orderLineRepository->findOneBy(['itemManager' => $itemId]);
        if (!$orderLine) {
            return $this->json([
                'response' => 'Not found',
            ]);
        }
        return $this->json([
            'response' => $orderLine->getId(),
        ]);
    }
    // Rout for returning an order line as a JSON for a given id
    #[Route('/get/orderline/{id}', name: 'get_orderline_id')]
    public function getOrderLineId(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $orderLineRepository = $entityManager->getRepository(OrderLine::class);
        $orderLine = $orderLineRepository->find($id);
        if (!$orderLine) {
            return $this->json([
                'response' => 'Not found',
            ]);
        }
        return $this->json([
            'response' => $orderLine,
        ]);
    }
    // Route to retrive all order lines ids for a given item manager id
    #[Route('/get/orderlines/itemManager/{id}', name: 'get_orderlines')]
    public function getOrderLines(int $itemId): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $orderLineRepository = $entityManager->getRepository(OrderLine::class);
        $orderLines = $orderLineRepository->findBy(['itemManager' => $itemId]);
        if (!$orderLines) {
            return $this->json([
                'response' => 'Not found',
            ]);
        }
        $orderLinesIds = [];
        foreach ($orderLines as $orderLine) {
            $orderLinesIds[] = $orderLine->getId();
        }
        return $this->json([
            'response' => $orderLinesIds,
        ]);
    }
    // Route to update an the quantity for a given id
    #[Route('/update/orderline/quantity/{quantity}/id-orderline/{id}', name: 'update_orderline_quantity')]
    public function updateOrderLineQuantity(int $quantity, int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $orderLineRepository = $entityManager->getRepository(OrderLine::class);
        $orderLine = $orderLineRepository->find($id);
        if (!$orderLine) {
            return $this->json([
                'response' => 'Not found',
            ]);
        }
        $orderLine->setQuantity($quantity);
        $entityManager->persist($orderLine);
        $entityManager->flush();
        return $this->json([
            'response' => 'Updated',
        ]);
    }
    // Route to update an the cut length for a given id
    #[Route('/update/orderline/cut-length/{cutLength}/id-orderline/{id}', name: 'update_orderline_cut_length')]
    public function updateOrderLineCutLength(float $cutLength, int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $orderLineRepository = $entityManager->getRepository(OrderLine::class);
        $orderLine = $orderLineRepository->find($id);
        if (!$orderLine) {
            return $this->json([
                'response' => 'Not found',
            ]);
        }
        $orderLine->setCutLength($cutLength);
        $entityManager->persist($orderLine);
        $entityManager->flush();
        return $this->json([
            'response' => 'Updated',
        ]);
    }
    // Route to update an the cut price for a given id
    #[Route('/update/orderline/cut-price/{cutPrice}/id-orderline/{id}', name: 'update_orderline_cut_price')]
    public function updateOrderLineCutPrice(float $cutPrice, int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $orderLineRepository = $entityManager->getRepository(OrderLine::class);
        $orderLine = $orderLineRepository->find($id);
        if (!$orderLine) {
            return $this->json([
                'response' => 'Not found',
            ]);
        }
        $orderLine->setCutPrice($cutPrice);
        $entityManager->persist($orderLine);
        $entityManager->flush();
        return $this->json([
            'response' => 'Updated',
        ]);
    }
    // Route to update an the discount for a given id
    #[Route('/update/orderline/discount/{discount}/id-orderline/{id}', name: 'update_orderline_discount')]
    public function updateOrderLineDiscount(float $discount, int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $orderLineRepository = $entityManager->getRepository(OrderLine::class);
        $orderLine = $orderLineRepository->find($id);
        if (!$orderLine) {
            return $this->json([
                'response' => 'Not found',
            ]);
        }
        $orderLine->setDiscount($discount);
        $entityManager->persist($orderLine);
        $entityManager->flush();
        return $this->json([
            'response' => 'Updated',
        ]);
    }
    // Route to delete an order line for a given id
    #[Route('/delete/orderline/{id}', name: 'delete_orderline')]
    public function deleteOrderLine(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $orderLineRepository = $entityManager->getRepository(OrderLine::class);
        $orderLine = $orderLineRepository->find($id);
        if (!$orderLine) {
            return $this->json([
                'response' => 'Not found',
            ]);
        }
        $entityManager->remove($orderLine);
        $entityManager->flush();
        return $this->json([
            'response' => 'Deleted',
        ]);
    }
}
