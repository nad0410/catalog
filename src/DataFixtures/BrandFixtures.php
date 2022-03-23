<?php

namespace App\DataFixtures;

use App\Entity\Brand;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BrandFixtures extends Fixture implements OrderedFixtureInterface
{
    // Definition de la liste des categories
    const DATA = [
        [
            'name' => "Marque 1",
            'reference' => "brand-1",
        ],
        [
            'name' => "Marque 2",
            'reference' => "brand-2",
        ],
        [
            'name' => "Marque 3",
            'reference' => "brand-3",
        ],

    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::DATA as $data)
        {
            $brand = new Brand;

            $brand->setName( $data['name'] );

            $this->setReference( $data['reference'], $brand);

            $manager->persist( $brand );
        }

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 1;
    }
}