<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as Faker;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Faker::create('fr_FR');

        // juste pour gagner du temps dans l'exécution de la fixture
        // ce n'est pas à faire pour des vrais utilisateurs !
        $password = $this->hasher->hashPassword((new User()), 'password');

        $admin = new User();
        $admin
            ->setEmail('admin@mail.com')
            ->setPassword($password)
            ->setUsername($faker->userName())
            ->setLastname($faker->lastname())
            ->setFirstname($faker->firstname())
            ->setRoles(['ROLE_ADMIN'])
        ;
        $manager->persist($admin);

        for ($i=0; $i < 100; $i++) { 
            $user = new User();
            $user
                ->setEmail($faker->email())
                ->setPassword($password)
                ->setUsername($faker->userName())
                ->setLastname($faker->lastname())
                ->setFirstname($faker->firstname())
            ;

            $manager->persist($user);
        }

        $manager->flush();
    }
}
