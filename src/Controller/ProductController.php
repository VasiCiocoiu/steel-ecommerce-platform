<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    // Route for retriving all the information for a product for a given id
    #[Route('/product/{id}', name: 'product')]
    public function product(int $id): Response
    {
        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);
        if (!$product) {
            throw $this->createNotFoundException('Product not found');
        }
        return $this->json([
            'id' => $product->getId(),
            'productName' => $product->getProductName(),
            'productDescription' => $product->getProductDescription(),
            'photo' => $product->getPhoto(),
        ]);
    }
    // Route to retrieve all the products ids
    #[Route('/get/productIds', name: 'products')]
    public function products(): Response
    {
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();
        $productIds = [];
        foreach ($products as $product) {
            $productIds[] = $product->getId();
        }
        return $this->json($productIds);
    }
    // Route to retrieve the product Id based on name
    #[Route('/get/productId/{name}', name: 'product_id')]
    public function productId(string $name): Response
    {
        $product = $this->getDoctrine()->getRepository(Product::class)->findOneBy(['productName' => $name]);
        if (!$product) {
            throw $this->createNotFoundException('Product not found');
        }
        return $this->json([
            'id' => $product->getId(),
        ]);
    }
}
