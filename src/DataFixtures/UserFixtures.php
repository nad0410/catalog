<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    /**
    * Password Encored
    *
    * @var userPasswordHasherInterface
    */
    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    //  definition de la listes des utilisateurs
    const DATA = [

        // user 1
        [
            'firstname' => "John",
            'lastname' => "DOE",
            'email' => "john@doe.com",
            'password' => "123456",
            'birthday' => "1982-11-04",
            'genre' => "M",
            'roles' => null,
        ],

        // user 2
        [
            'firstname' => "Jane",
            'lastname' => "DOE",
            'email' => "jane@doe.com",
            'password' => "123456",
            'password' => "123456",
            'birthday' => "1984-12-27",
            'genre' => "F",
            'roles' => null,
        ],

        // user 3
        [
            'firstname' => "Bob",
            'lastname' => "DOE",
            'email' => "bob@doe.com",
            'password' => "123456",
            'password' => "123456",
            'birthday' => "1974-06-18",
            'genre' => "M",
            'roles' => null,
        ],

    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::DATA as $data)
        {
            // instance de l'entity categorie
            $user = new User;
            //  hash du password
            $password = $this->hasher->hashPassword($user, $data['password']);
            

            // Affectation des valeurs aux proprietes de $category
            $user->setFirstname( $data['firstname'] );
            $user->setLastname( $data['lastname'] );
            $user->setEmail( $data['email'] );
            $user->setPassword( $password );
            $user->setBirthday( new \DateTime( $data['birthday'] ) );
            $user->setGenre( $data['genre'] );
            // $user->setRoles( $data['roles'] );
   
            // on persiste
            $manager->persist( $user );
        }

            // $product = new Product();
            // $manager->persist($product);
        $manager->flush();
    }
}
