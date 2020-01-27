<?php

namespace App\Controller;

use App\Entity\Cas;
use App\Repository\CasRepository;
use App\Form\CasType;
use App\Entity\Tarif;
use App\Repository\TarifRepository;
use App\Form\TarifType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @Route("/admin")
 * @IsGranted("ROLE_ADMIN")
 */
class CasController extends AbstractController
{
    /**
     * @Route("/cas", name="cas_index")
     */
    public function index(CasRepository $repo)
    {
        $cas = $repo->findAll();

        return $this->render('cas/index.html.twig', [
            'controller_name' => 'casController',
            'cas' => $cas
        ]);
    }

    /**
    * @Route("/cas/ajouter", name="cas_ajouter")
    * @Route("/cas/{id}/modifier", name="cas_modifier")
    * @IsGranted("ROLE_ADMIN")
    */
    public function ajouterCas(Cas $cas = null, Request $request, ObjectManager $manager)
    {
        if(!$cas){
            $cas = new Cas();
        }

        $form = $this->createForm( CasType::class, $cas );
        
        $form->handleRequest( $request );
               
        if( $form->isSubmitted() && $form->isValid() ){
                     
                $manager->persist( $cas );
                $manager->flush();
                return $this->redirectToRoute('cas_index') ;
        }
        
        return $this->render('cas/ajouter.html.twig', 
            ['formCas' => $form->createView(),
            'editMode' => $cas->getId() !== null
            ]);
    }

    /**
    * @Route("/cas/{id}/supprimer", name="cas_supprimer")
    * @IsGranted("ROLE_ADMIN")
    */
    public function supprimerCas(Cas $cas, Request $request, ObjectManager $manager)
    {
        $manager->remove($cas);
        $manager->flush();

        return $this->redirectToRoute('cas_index');
    }

    /**
     * @Route("/cas/{id}/afficher", name="cas_afficher")
     */
    public function showOne(Cas $cas)
    {
        return $this->render('cas/afficher.html.twig', [
            'cas' => $cas
        ]);
    }
    /**
     * @Route("/cas/tarif", name="tarif_index")
     */
    public function tarifIndex(TarifRepository $trepo)
    {
        $tarifs = $trepo->findAll();

        return $this->render('tarif/index.html.twig', [
            'controller_name' => 'casController',
            'tarifs' => $tarifs
        ]);
    }

    /**
    * @Route("/cas/tarif/ajouter", name="tarif_ajouter")
    * @Route("/cas/tarif/{id}/modifier", name="tarif_modifier")
    * @IsGranted("ROLE_ADMIN")
    */
    public function ajouterTarif(Tarif $tarif = null, Request $request, ObjectManager $manager)
    {
        if(!$tarif){
            $tarif = new Tarif();
        }

        $form = $this->createForm( TarifType::class, $tarif );
        
        $form->handleRequest( $request );
               
        if( $form->isSubmitted() && $form->isValid() ){
                     
                $manager->persist( $tarif );
                $manager->flush();
                return $this->redirectToRoute('tarif_index') ;
        }
        
        return $this->render('tarif/ajouter.html.twig', 
            ['formTarif' => $form->createView(),
            'editMode' => $tarif->getId() !== null
            ]);
    }

    /**
    * @Route("/cas/tarif/{id}/supprimer", name="tarif_supprimer")
    * @IsGranted("ROLE_ADMIN")
    */
    public function supprimerTarif(Tarif $tarif, Request $request, ObjectManager $manager)
    {
        $manager->remove($tarif);
        $manager->flush();

        return $this->redirectToRoute('tarif_index');
    }

    /**
     * @Route("/cas/tarif/{id}/afficher", name="tarif_afficher")
     */
    public function showOneTarif(Tarif $tarif)
    {
        return $this->render('tarif/afficher.html.twig', [
            'tarif' => $tarif
        ]);
    }
}
