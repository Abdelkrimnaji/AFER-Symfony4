<?php
namespace App\DataFixtures;
use Faker\Factory;
use App\Entity\Animateur;
use App\Entity\AnimateurStatut;
use App\Entity\AnimateurFonction;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
class AnimateurFixtures extends Fixture
{

    
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');
        for ($j = 1; $j < 3; $j++) { 
            $fonction = new AnimateurFonction();
            $fonction->setNom($faker->word);
            $manager->persist($fonction);
        
            for ($k = 1; $k < 3; $k++) { 
                $statut = new AnimateurStatut();
                $statut->setNom($faker->word);
                $manager->persist($statut);
            }
            for($i = 1; $i < 5; $i++){
                $animateur = new Animateur();
                
                $animateur->setNomAnimateur($faker->firstName);
                $animateur->setPrenomAnimateur($faker->lastName);
                $animateur->setRaisonSocialeAnimateur($faker->word);
                $animateur->setGtaAnimateur($faker->boolean());
                $animateur->setCpAnimateur($faker->postcode);
                $animateur->setCommuneAnimateur($faker->departmentName);
                $animateur->setRegionAnimateur($faker->region);
                $animateur->setNumeroRueAnimateur($faker->randomNumber);
                $animateur->setRueAnimateur($faker->streetAddress);
                $animateur->setNumeroRueAnimateur($faker->streetAddress);
                $animateur->setNumeroPortableAnimateur($faker->mobileNumber);
                $animateur->setNumeroFixeAnimateur($faker->phoneNumber);
                $animateur->setEmailAnimateur($faker->email);
                $animateur->setUrssafAnimateur($faker->numberBetween($min = 1000, $max = 9000));
                $animateur->setSiretAnimateur($faker->siret);
                $animateur->setObservationsAnimateur($faker->sentence());
                $animateur->setAnimateurFonction($fonction);
                $animateur->setAnimateurStatut($statut);
                $manager->persist($animateur);
            }
        }
        $manager->flush();
    }
}
