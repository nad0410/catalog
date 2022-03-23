<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AProductFixtures extends Fixture implements OrderedFixtureInterface
{
    // Definition de la liste des categories
    const DATA = [
        [
            'title' => "iPhone",
            'description' => "",
            'price' => 999.99,
            'brand' => "brand-3",
            "categories" => [
                "categ-2",
            ]
        ],
        [
            'title' => "Z Fold",
            'description' => "",
            'price' => 999.99,
            'brand' => "brand-1",
            "categories" => []
        ],
        [
            'title' => "Produit 3",
            'description' => "",
            'price' => 999.99,
            'brand' => "brand-2",
            "categories" => [
                "categ-1",
                "categ-3",
            ]
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::DATA as $data)
        {
            $product = new Product;

            $product->setTitle( $data['title'] );
            $product->setDescription( $data['description'] );
            $product->setPrice( $data['price'] );
            

            $product->setBrand( $this->getReference($data['brand']) );

            foreach ($data['categories'] as $category)
            {
                $product->addCategory($this->getReference($category));
            } 

            $manager->persist( $product );
        }

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 2;
    }
}