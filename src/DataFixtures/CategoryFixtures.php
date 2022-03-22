<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    //  definition de la listes des categories
    const DATA = [

        // categorie 1
        [
            'name' => "Sport",
            'description' => "Description de la categorie sport",
            'color' => "#FF0000",
        ],

        // categorie 2
        [
            'name' => "Informatique",
            'description' => null,
            'color' => "#00FF00",
        ],

        // categorie 3
        [
            'name' => "Boisson",
            'description' => "Description de la categorie boisson",
            'color' => "#0000FF",
        ],

    ];
    public function load(ObjectManager $manager): void
    {

        foreach (self::DATA as $data)
        {
            // instance de l'entity categorie
            $category = new Category;

            // Affectation des valeurs aux proprietes de $category
            $category->setName( $data['name'] );
            $category->setDescription( $data['description'] );
            $category->setColor( $data['color'] );

            // on persiste
            $manager->persist( $category );
        }


        // $product = new Product();
        // $manager->persist($product);
        $manager->flush();
    }
}
