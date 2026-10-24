<?php

namespace App\DataFixtures;

use App\Entity\Dimension;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;


class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $products = [
            'Corniere ailes egales' => 1,
            'Corniere ailes inegales' => 2,
            'Fer en T' => 3,
            'Fer plat' => 4,
            'Poutrelles HEA HEB' => 5,
            'Poutrelles IPE normales' => 6,
            'Poutrelles UPE' => 7,
            'Tube carre' => 8,
            'Tube rond' => 9,
        ];

        foreach ($products as $name => $productId) {
            $product = new Product();
            $product->setProductName($name);
            $product->setProductDescription($faker->text);
            $product->setPhoto($faker->text);
            $manager->persist($product);
        }

        $manager->flush();
    }
}
