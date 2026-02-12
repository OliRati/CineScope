<?php

namespace App\DataFixtures;

use App\Entity\Film;
use App\Entity\Platforme;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Xefi\Faker\Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = new Faker('fr_FR');
        for ($i = 0; $i < 10; $i++) {
            $platform = new Platforme();
            $platform->setName($faker->words(words: 4))
            ->setUrl($faker->imageUrl(width:50, height: 50))
            ->setLogo($faker->imageUrl(width:50, height: 50));
            $manager->persist($platform);

            $film = new Film();
            $film->setTitle($faker->words(words: 3) )
            ->setSynopsis($faker->sentences(sentences: 3))
            ->setReleaseYear($faker->number(min:1900,max: 2026))
            ->addPlatforme($platform);
            $manager->persist($film);
            
        }


       

        $manager->flush();
    }
}
