<?php

namespace App\Controller;

use App\Entity\Stock;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

class StockController extends AbstractController
{
    // Route for total of stock with a stockLength superior to given in parameter
    #[Route('/stock/total/dimension/{dimensionId}/length/{length}', name: 'stock_total_length')]
    public function totalStockLengthForDimension(int $dimensionId, float $length): Response
    {
        $stockRepository = $this->getDoctrine()->getRepository(Stock::class);
        $totalStockQuantity = $stockRepository->createQueryBuilder('s')
            ->select('SUM(s.stockQuantity as totalQuantity')
            ->join('s.dimension', 'd')
            ->where('p.id = :dimensionId')
            ->andWhere('s.stockLength > :length')
            ->setParameter('dimensionId', $dimensionId)
            ->setParameter('length', $length)
            ->getQuery()
            ->getSingleScalarResult();

        return $this->json([
            'totalStockQuantity' => $totalStockQuantity,
        ]);
    }

    // Route for gettin stockQuantity of given dimension with a stockLength of 0.5
    #[Route('/stock/quantity/dimension/{dimensionId}', name: 'stock_quantity_dimension')]
    public function stockQuantityForDimension(int $dimensionId): Response
    {
        $stockRepository = $this->getDoctrine()->getRepository(Stock::class);
        $stockQuantity = $stockRepository->createQueryBuilder('s')
            ->select('s.stockQuantity')
            ->join('s.dimension', 'd')
            ->where('p.id = :dimensionId')
            ->andWhere('s.stockLength <= 0.5')
            ->setParameter('dimensionId', $dimensionId)
            ->getQuery()
            ->getSingleScalarResult();

        return $this->json([
            'stockQuantity' => $stockQuantity,
        ]);
    }
    // Route for removing a given quantity of stock from a given dimension with a stockLength of 0.5
    #[Route('/stock/remove/piece/dimension/{dimensionId}', name: 'stock_remove_piece_dimension')]
    public function removePieceFromStock(int $dimensionId, int $quantity): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $stockRepository = $this->getDoctrine()->getRepository(Stock::class);
        $stock = $stockRepository->createQueryBuilder('s')
            ->select('s')
            ->join('s.dimension', 'd')
            ->where('d.id = :dimensionId')
            ->andWhere('s.stockLength <= 0.5')
            ->setParameter('dimensionId', $dimensionId)
            ->getQuery()
            ->getSingleResult();

        if ($stock->getStockQuantity() >= $quantity) {
            $stock->setStockQuantity($stock->getStockQuantity() - $quantity);
            $entityManager->persist($stock);
            $entityManager->flush();

            return $this->json([
                'response' => 'Ok',
            ]);
        } else {
            return $this->json([
                'response' => 'No stock',
            ]);
        }
    }
    // Route for removing a given quantity of stock from a given dimension for a given length

    // TO IMPROVE
    #[AsController()]
    #[Route('/stock/remove/quantity/dimension/{dimensionId}/length/{length}', name: 'stock_remove_quantity_dimension_length')]
    public function removeQuantityFromStockForLength(int $dimensionId, float $length, int $quantity): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $stockRepository = $this->getDoctrine()->getRepository(Stock::class);
        $stock = $stockRepository->createQueryBuilder('s')
            ->select('s')
            ->join('s.dimension', 'd')
            ->where('d.id = :dimensionId')
            ->andWhere('s.stockLength > :length')
            ->orderBy('s.stockLength', 'ASC')
            ->setParameter('dimensionId', $dimensionId)
            ->setParameter('length', $length)
            ->getQuery()
            ->getResult();

        if (!empty($stock)) {
            $smallestLength = $stock[0]->getStockLength();
            $difference = $smallestLength - $length;
            $quantityRemaining = $quantity;

            foreach ($stock as $stockItem) {
                if ($stockItem->getStockQuantity() >= $quantityRemaining) {
                    $stockItem->setStockQuantity($stockItem->getStockQuantity() - $quantityRemaining);
                    $entityManager->persist($stockItem);
                    $entityManager->flush();
                    $quantityRemaining = 0;
                    break;
                } else {
                    $quantityToRemove = $stockItem->getStockQuantity();
                    $stockItem->setStockQuantity(0);
                    $entityManager->persist($stockItem);
                    $entityManager->flush();
                    $quantityRemaining -= $quantityToRemove;
                }
            }

            if ($quantityRemaining > 0) {
                return $this->json([
                    'response' => 'No stock',
                ]);
            } else {
                if ($difference > 0) {
                    $newStock = new Stock();
                    $newStock->setStockLength($stock[0]->getStockLength());
                    $newStock->setStockLength($length);
                    $newStock->setStockQuantity($quantity);
                    $entityManager->persist($newStock);
                    $entityManager->flush();
                }

                return $this->json([
                    'response' => 'Ok',
                ]);
            }
        } else {
            return $this->json([
                'response' => 'No stock',
            ]);
        }
    }
    // Route for adding a given quantity of stock to a given dimension for a length of 6
    #[Route('/stock/add/quantity/{quantity}/dimension/{dimensionId}', name: 'stock_add_quantity_dimension')]
    public function addQuantityToStock(int $dimensionId, int $quantity): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $stockRepository = $this->getDoctrine()->getRepository(Stock::class);
        $stock = $stockRepository->createQueryBuilder('s')
            ->select('s')
            ->join('s.dimension', 'd')
            ->where('d.id = :dimensionId')
            ->andWhere('s.stockLength = 6')
            ->setParameter('dimensionId', $dimensionId)
            ->getQuery()
            ->getSingleResult();

        $stock->setStockQuantity($stock->getStockQuantity() + $quantity);
        $entityManager->persist($stock);
        $entityManager->flush();

        return $this->json([
            'response' => 'Ok',
        ]);
    }
}
