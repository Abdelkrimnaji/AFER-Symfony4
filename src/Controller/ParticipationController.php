<?php

namespace App\Controller;

use App\Entity\Stage;
use App\Entity\Stagiaire;
use App\Entity\Participation;
use App\Form\ParticipationType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/admin")
 * @IsGranted("ROLE_ADMIN")
 */
class ParticipationController extends AbstractController
{
    /**
     * @Route("/participation", name="participation")
     */
    public function index()
    {
        return $this->render('participation/index.html.twig', [
            'controller_name' => 'ParticipationController',
        ]);
    }
    
/**
     *  @Route("/stage/participation/ajouter", name="stage_participation_ajouter")
     *  @Route("/stage/{id}/modifier", name="stage_modifier")
     */
    public function participationForm(Participation $participation = null, Request $request, ObjectManager $manager)
    {
        if(!$participation){
        $participation = new Participation();
        }

       
        $form = $this->createForm(ParticipationType::class, $participation);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
           
            $manager->persist($participation);
            $manager->flush();
            return $this->redirectToRoute('stage_index');
        }
        return $this->render('participation/ajouter.html.twig', [
            'formParticipation' => $form->createView(),
            
           
        ]);
    }
}