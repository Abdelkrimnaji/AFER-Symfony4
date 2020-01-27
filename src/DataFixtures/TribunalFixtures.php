<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Tribunal;
use App\Entity\TribunalService;
use App\Entity\TribunalAutorite;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TribunalFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        for ($j = 1; $j < 3; $j++) { 
            $service = new TribunalService();
            $service->setNom($faker->word);
            $manager->persist($service);
            $manager->flush();
        }

        for ($k = 1; $k < 3; $k++) { 
            $autorite = new TribunalAutorite();
            $autorite->setNom($faker->word);
            $manager->persist($autorite);
            $manager->flush();
        }
   
        for($i = 1; $i < 3; $i++){
            $tribunal = new Tribunal();
            
            $tribunal->setNomTribunal("Tribunal n°$i");
            $tribunal->setAdresseTribunal($faker->streetAddress);
            $tribunal->setNumeroAdresseTribunal($faker->randomNumber);
            $tribunal->setCommuneTribunal($faker->region);
            $tribunal->setCpTribunal($faker->postcode);
            $tribunal->setTribunalAutorite($autorite);
            $tribunal->setTribunalService($service);

            $manager->persist($tribunal);
            $manager->flush();
        }

    }
}
