<?php

namespace App\DataFixtures;

use App\Entity\Commune;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


class CommuneFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $csv = fopen('communes.csv', 'r');

        $i = 0;

        while (!feof($csv)) {
            $line = fgetcsv($csv);

        
            $commune[$i] = new Commune();
            $commune[$i]->setRegion($line[2]);
            $commune[$i]->setDepartement($line[5]);
            $commune[$i]->setNomCommune($line[8]);
            $commune[$i]->setCp($line[9]);
            $commune[$i]->setLatitude($line[11]);
            $commune[$i]->setLongitude($line[12]);
          

            $manager->persist($commune[$i]);

            $manager->flush();

            if ($i % 25 == 0) 
            { $manager->clear(); 

            dump("Importing commune ...".$line[8]);
        }

            $i = $i + 1;
        }

        fclose($csv);
        
       
    }

    
}