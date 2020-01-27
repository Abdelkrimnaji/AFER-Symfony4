<?php

namespace App\Controller;

use App\Entity\NatureInfraction;
use App\Form\NatureInfractionType;
use App\Repository\NatureInfractionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/admin")
 * @IsGranted("ROLE_ADMIN")
 */
class NatureInfractionController extends AbstractController
{
    /**
     * @Route("/tribunal/nature_infraction", name="nature_infraction_index")
     */
    
            public function index(natureInfractionRepository $repo)
            {
                $natureInfractions = $repo->findAll();
        
                return $this->render('natureInfraction/index.html.twig', [
                    'controller_name' => 'natureInfractionController',
                    'natureInfractions' => $natureInfractions
                ]);
            }
            /**
             *  @Route("/tribunal/nature_infraction/ajouter", name="nature_infraction_ajouter")
             *  @Route("/tribunal/nature_infraction/{id}/modifier", name="nature_infraction_modifier")
             */
            public function natureInfractionForm(NatureInfraction $natureInfraction = null, Request $request, ObjectManager $manager)
            {
                if(!$natureInfraction){
                $natureInfraction = new natureInfraction();
                }
                $form = $this->createForm(NatureInfractionType::class, $natureInfraction);
                $form->handleRequest($request);
                if($form->isSubmitted() && $form->isValid()){
                    // dump($request);
                    // die();
                    $manager->persist($natureInfraction);
                    $manager->flush();
                    return $this->redirectToRoute('nature_infraction_index');
                }
                return $this->render('natureInfraction/ajouter.html.twig', [
                    'formNatureInfraction' => $form->createView(),
                    'editMode' => $natureInfraction->getId() !== null
                ]);
            }
            /**
             *  @Route("/tribunal/nature_infraction/{id}/supprimer", name="nature_infraction_supprimer")
             */
            public function delete(NatureInfraction $natureInfraction, ObjectManager $manager)
            {
                $manager->remove($natureInfraction);
                $manager->flush();
                return $this->redirectToRoute('nature_infraction_index');
            }
}
