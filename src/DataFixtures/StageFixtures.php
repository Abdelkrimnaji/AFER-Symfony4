<?php
namespace App\DataFixtures;
use Faker\Factory;
use App\Entity\Stage;
use App\Entity\LieuStage;
use App\Entity\Animateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
class StageFixtures extends Fixture
{ 
    public function load(ObjectManager $manager)
{
    $this->loadStage( $manager );
   
}
    public function loadStage(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');
       
            for($i = 1; $i < 7; $i++){
                $stage = new Stage();
                $lieuStage = $this->loadLieuStage($manager);
                $manager->persist($lieuStage);
                $stage->setNumeroStage($faker->firstName);
                $stage->setStageProgrammeOfficiel($faker->boolean());
                $stage->setDated($faker->datetime);
                $stage->setDatef($faker->datetime);
                $stage->setLieuStage($lieuStage);
               
                $manager->persist($stage);
            
        }
        $manager->flush();
    }
        
    
    public function loadLieuStage(ObjectManager $manager)
        {   
            $faker = \Faker\Factory::create('fr_FR');
            
                $lieustage = new lieuStage();
                $lieustage->setNomEtablissement($faker->word);
                $lieustage->setAgrement($faker->randomNumber);
                $lieustage->setAdresseStage($faker->streetName);
                $lieustage->setNumeroAdresseStage($faker->randomNumber);
                $lieustage->setNomCommune($faker->City);
                $lieustage->setTelephoneStage($faker->randomNumber);
               
                return $lieustage;
        $manager->flush();
    }
    
}