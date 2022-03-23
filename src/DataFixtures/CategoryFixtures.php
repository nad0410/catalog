<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture implements OrderedFixtureInterface
{
    // Definition de la liste des categories
    const DATA = [

        // Categorie 1
        [
            'name' => "Sport",
            'description' => "Description de la catégorie sport",
            'color' => "#FF0000",
            'reference' => "categ-1",
        ],

        // Categorie 2
        [
            'name' => "Informatique",
            'description' => null,
            'color' => "#00FF00",
            'reference' => "categ-2",
        ],

        // Categorie 3
        [
            'name' => "Boisson",
            'description' => "Description de la catégorie boisson",
            'color' => "#0000FF",
            'reference' => "categ-3",
        ],

    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::DATA as $data)
        {
            // Instance de l'entité category
            $category = new Category;

            // Affectation des valeurs aux propriété de $category
            $category->setName( $data['name'] );
            $category->setDescription( $data['description'] );
            $category->setColor( $data['color'] );

            $this->setReference( $data['reference'], $category);
            // On persiste l'entité
            $manager->persist( $category );
        }

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 1;
    }
}