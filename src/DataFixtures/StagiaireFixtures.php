<?php

namespace App\DataFixtures;

use Faker\Factory;

use App\Entity\Stagiaire;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class StagiaireFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');



            for($i = 1; $i < 7; $i++){
                $stagiaire = new Stagiaire();
                
                
                $stagiaire->setNomStagiaire($faker->firstName);
                $stagiaire->setPrenomStagiaire($faker->lastName);
                $stagiaire->setCommuneStagiaire($faker->DepartmentName);
                $stagiaire->setNomNaissanceStagiaire($faker->lastname);
                $stagiaire->setDateNaissanceStagiaire($faker->datetime);
                $stagiaire->setLieuNaissanceStagiaire($faker->region);
                $stagiaire->setAdresseStagiaire($faker->streetAddress);
                $stagiaire->setNationaliteStagiaire($faker->word);
                $stagiaire->setNumeroPortableStagiaire($faker->phoneNumber);
                $stagiaire->setNumeroFixeStagiaire($faker->phoneNumber);
                $stagiaire->setEmailStagiaire($faker->email);
                $stagiaire->setCarteJeuneStagiaire($faker->boolean());
                $stagiaire->setPartenaireStagiaire($faker->boolean());
                $stagiaire->setAdherentStagiaire($faker->boolean());
                $stagiaire->setNumeroAdresseStagiaire($faker->randomNumber);
              
                $manager->persist($stagiaire);
            }
        $manager->flush();
    }
}

