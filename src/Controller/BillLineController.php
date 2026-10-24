<?php

namespace App\Controller;

use App\Entity\BillLine;
use App\Entity\Dimension;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BillLineController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private HttpFoundationRequest $request;

    public function __construct(EntityManagerInterface $entityManager, RequestStack $requestStack)
    {
        $this->entityManager = $entityManager;
        $this->request = $requestStack->getCurrentRequest();
    }

    #add bill line

    #[Route('api/bill/line/add', name: 'app_bill_line_add', methods: ['POST'])]
public function addBillLine(): JsonResponse
{
    $data = json_decode($this->request->getContent(), true);

    $dimension = $this->entityManager->getRepository(Dimension::class)->find($data['id']);

    if (!$dimension) {
        return $this->json(['error' => 'Dimension not found'], 404);
    }

    $dimension->setSizeA($data['sizeA']);
    $dimension->setSizeB($data['sizeB']);
    $dimension->setSizeC($data['sizeC']);
    $dimension->setSizeD($data['sizeD']);
    $dimension->setSizeE($data['sizeE']);
    $dimension->setUnitPrice($data['unit_price']);

    // Assuming Product is another entity and you have its ID in the request data
    $product = $this->entityManager->getRepository(Product::class)->find($data['product_id']);
    if ($product) {
        $dimension->addProduct($product);
    }

    // Create a new BillLine entity with the specified properties
    $billLine = new BillLine();
    $billLine->setProductName($data['productName']);
    $billLine->setUnitPrice($data['unit_price']);
    $billLine->setProductQuantity($data['product_quantity']);
    $billLine->setCutLength($data['cut_length']);
    $billLine->setDiscount($data['discount']);
    $billLine->setCutPrice($data['cut_price']);
    $billLine->setDimension($dimension);

    // Persist the new BillLine entity
    $this->entityManager->persist($billLine);

    // Persist the changes to the Dimension entity
    $this->entityManager->flush();

    return $this->json(['success' => 'Dimension and BillLine updated successfully']);
}

    
    
    

    #get bill lines
    #[Route('api/bill/line', name: 'app_bill_line')]
    public function getBillLineByUser(): JsonResponse
    {
        $billLine = $this->entityManager->getRepository(BillLine::class)->findAll();
        if (!$billLine) {
            return $this->json(['error' => 'No bill line found'], Response::HTTP_NOT_FOUND);
        }
        return $this->json($billLine);

    }
}
