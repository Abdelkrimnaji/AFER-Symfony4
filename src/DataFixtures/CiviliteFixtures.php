<?php

namespace App\DataFixtures;

use App\Entity\Civilite;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CiviliteFixtures extends Fixture
{
   
public function load(ObjectManager $manager)
{
   
    $this->loadCivilite ($manager);
}

    private function loadCivilite( ObjectManager $manager) {


        $tblcivilites = ["Monsieur", 
        "Madame"];

        foreach ($tblcivilites as $tblcivilite) {
        $civilite = new Civilite();
        $civilite->setNomCivilite($tblcivilite);
        $manager->persist($civilite);
        };
        
        $manager->flush();

    }
}

