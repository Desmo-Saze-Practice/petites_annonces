<?php

namespace App\DataFixtures;

use App\Entity\Annonce;
use App\Entity\Tag;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as Faker;

class AnnonceFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $userRepository = $manager->getRepository(User::class);
        $users = $userRepository->findAll();
        $usersLength = count($users)-1; //potentiellement 100 // mais ça va de 0 à 99

        $tagRepository = $manager->getRepository(Tag::class);
        $tags = $tagRepository->findAll();
        $tagLength = count($tags)-1;

        $faker = Faker::create('fr_FR');

        for ($i=0; $i < 500; $i++) { 
            $user = $users[rand(0, $usersLength)]; // on ne peut pas accéder à l'index 100
            $tag = $tags[rand(0, $tagLength)];
            $annonce = new Annonce();
            $annonce
                ->setTitle($faker->word().$i)
                ->setDescription($faker->text)
                ->setStatus($faker->randomElement([
                    Annonce::STATUS_VERY_BAD,
                    Annonce::STATUS_BAD, 
                    Annonce::STATUS_GOOD,
                    Annonce::STATUS_VERY_GOOD,
                    Annonce::STATUS_PERFECT
                ]))
                ->setPrice($faker->randomNumber())
                ->setUser($user)
                ->addTag($tag)
            ;

            $manager->persist($annonce);
            // dans le prePersist de Annonce, on a mis isSold = false
            // pour avoir un boolean aléatoire pour isSold il faut le mettre après le persist
            $annonce->setIsSold($faker->boolean());
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            TagFixtures::class
        ];
    }
}
