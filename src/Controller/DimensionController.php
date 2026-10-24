<?php

namespace App\Controller;

use App\Entity\Dimension;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DimensionController extends AbstractController
{
    // Route for retriving all the dimensions for a given id product
    #[Route('/get/dimensions/{id}', name: 'dimension')]
    public function getDimensions(int $id): Response
    {
        $dimensions = $this->getDoctrine()->getRepository(Dimension::class)->findBy(['product' => $id]);

        if (empty($dimensions)) {
            throw $this->createNotFoundException('No dimensions found');
        }
        $dimensionData = [];
        foreach ($dimensions as $dimension) {
            $dimensionId = $dimension->getId();
            $sizeA = $dimension->getSizeA();
            $sizeB = $dimension->getSizeB();
            $sizeC = $dimension->getSizeC();
            $sizeD = $dimension->getSizeD();
            $sizeE = $dimension->getSizeE();


            $dimensionData[] = [
                'dimension' . '$dimensionId' =>
                [
                    'id' => $dimensionId,
                    'sizeA' => $sizeA,
                    'sizeB' => $sizeB,
                    'sizeC' => $sizeC,
                    'sizeD' => $sizeD,
                    'sizeE' => $sizeE,
                ],
            ];
        }
        return $this->json($dimensionData);
    }

    // Route for retriving the unitPrice for a given dimension id
    #[Route('/get/unitPrice/{id}', name: 'unitPrice')]
    public function getUnitPrice(int $id): Response
    {
        $dimension = $this->getDoctrine()->getRepository(Dimension::class)->find($id);

        if (empty($dimension)) {
            throw $this->createNotFoundException('No dimension found');
        }

        $unitPrice = $dimension->getUnitPrice();

        return $this->json(['unitPrice' => $unitPrice]);
    }

    //Route for retriving the linearMass for a given dimension id
    #[Route('/get/linearMass/{id}', name: 'linearMass')]
    public function getLinearMass(int $id): Response
    {
        $dimension = $this->getDoctrine()->getRepository(Dimension::class)->find($id);

        if (empty($dimension)) {
            throw $this->createNotFoundException('No dimension found');
        }

        $linearMass = $dimension->getLinearMass();
        return $this->json(['linearMass' => $linearMass]);
    }
}
