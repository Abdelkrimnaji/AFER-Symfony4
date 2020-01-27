<?php
namespace App\Controller;

use App\Entity\Animateur;
use App\Form\AnimateurType;
use App\Entity\AnimateurStatut;

use App\Entity\AnimateurFonction;
use App\Form\AnimateurStatutType;
use App\Form\AnimateurFonctionType;

use App\Repository\CommuneRepository;
use App\Repository\CiviliteRepository;
use App\Repository\AnimateurRepository;

use App\Repository\AnimateurStatutRepository;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\AnimateurFonctionRepository;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * @Route("/admin")
 * @IsGranted("ROLE_ADMIN")
 */
class AnimateurController extends AbstractController
{
    /**
     * @Route("/animateur", name="animateur_index")
     */
    public function index(AnimateurRepository $repo)
    {
        $animateurs = $repo->findAll();

        return $this->render('animateur/index.html.twig', [
            'controller_name' => 'AnimateurController',
            'animateurs' => $animateurs
        ]);
    }
    /**
     *  @Route("/animateur/ajouter", name="animateur_ajouter")
     *  @Route("/animateur/{id}/modifier", name="animateur_modifier")
     */
    public function animateurForm(Animateur $animateur = null,AnimateurRepository $repoAnimateur, Request $request, ObjectManager $manager, CiviliteRepository $repoCivilite)
    {
        if(!$animateur){
        $animateur = new Animateur();
        }
        $form = $this->createForm(AnimateurType::class, $animateur);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){


            
            $AnimateurNom = $animateur->getNomAnimateur();
            $AnimateurPrenom = $animateur->getPrenomAnimateur();
            $AnimateurSiret = $animateur->getSiretAnimateur();
            $nbrs = $repoAnimateur->counter($AnimateurNom,$AnimateurPrenom,$AnimateurSiret);
            $nbr = $nbrs[0][1];
            
            // $animateurCivilite = $request->request->get('animateur_civilite');
            // $civilite = $repoCivilite->find($animateurCivilite);

            if($animateur->getId() === null && $nbr === "0"){
                $manager->persist($animateur);
                $manager->flush();
            }else if($animateur->getId() !== null){
                $manager->persist($animateur);
                $manager->flush();
            }else{
                return $this->render('animateur/ajouter.html.twig', [
                    'formAnimateur' => $form->createView(),
                    'editMode' => $animateur->getId() !== null,
                    'error' => 'error'
                ]);
            }
            return $this->redirectToRoute('animateur_index');
        }
        return $this->render('animateur/ajouter.html.twig', [
            'formAnimateur' => $form->createView(),
            'editMode' => $animateur->getId() !== null
        ]);
    }
    /**
     *  @Route("/animateur/{id}/supprimer", name="animateur_supprimer")
     */
    public function delete(Animateur $animateur, ObjectManager $manager)
    {
        $manager->remove($animateur);
        $manager->flush();
        return $this->redirectToRoute('animateur_index');
    }
    /**
     * @Route("/animateur/{id}/afficher", name="animateur_afficher")
     */
    public function showOne(Animateur $animateur)
    {
        return $this->render('animateur/afficher.html.twig', [
            'animateur' => $animateur
        ]);
    }

    // ----- Affichage, ajout, modification et suppresion des fonctions pour les animateurs -----

    /**
     * @Route("/animateur/fonction", name="animateurFonction_index")
     */
    public function afficherFonction(AnimateurFonctionRepository $repo)
    {
        $animateurfonctions = $repo->findAll();

        return $this->render('animateur/indexFonction.html.twig', [
            'controller_name' => 'AnimateurController',
            'animateurfonctions' => $animateurfonctions
        ]);
    }

    /**
     *  @Route("/animateur/fonction/ajouter", name="animateurFonction_ajouter")
     *  @Route("/animateur/fonction/{id}/modifier", name="animateurFonction_modifier")
     */
    public function animateurFonctionForm(AnimateurFonction $animateurfonction = null, Request $request, ObjectManager $manager)
    {
        if(!$animateurfonction){
        $animateurfonction = new AnimateurFonction();
        }
        $form = $this->createForm(AnimateurFonctionType::class, $animateurfonction);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($animateurfonction);
            $manager->flush();
            return $this->redirectToRoute('animateurFonction_index');
        }
        return $this->render('animateur/ajouterFonction.html.twig', [
            'formAnimateurFonction' => $form->createView(),
            'editMode' => $animateurfonction->getId() !== null
        ]);
    }

    /**
     *  @Route("/animateur/fonction/{id}/supprimer", name="animateurFonction_supprimer")
     */
    public function supprimerAnimateurFonction(AnimateurFonction $animateurfonction, ObjectManager $manager)
    {
        $manager->remove($animateurfonction);
        $manager->flush();
        return $this->redirectToRoute('animateurFonction_index');
    }

    // ----- Affichage, ajout, modification et suppresion des statuts pour les animateurs -----

    /**
     * @Route("/animateur/statut", name="animateurStatut_index")
     */
    public function afficherStatut(AnimateurStatutRepository $repo)
    {
        $animateurstatuts = $repo->findAll();

        return $this->render('animateur/indexStatut.html.twig', [
            'controller_name' => 'AnimateurController',
            'animateurstatuts' => $animateurstatuts
        ]);
    }

    /**
     *  @Route("/animateur/statut/ajouter", name="animateurStatut_ajouter")
     *  @Route("/animateur/statut/{id}/modifier", name="animateurStatut_modifier")
     */
    public function animateurStatutForm(AnimateurStatut $animateurstatut = null, Request $request, ObjectManager $manager)
    {
        if(!$animateurstatut){
        $animateurstatut = new AnimateurStatut();
        }
        $form = $this->createForm(AnimateurStatutType::class, $animateurstatut);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($animateurstatut);
            $manager->flush();
            return $this->redirectToRoute('animateurStatut_index');
        }
        return $this->render('animateur/ajouterStatut.html.twig', [
            'formAnimateurStatut' => $form->createView(),
            'editMode' => $animateurstatut->getId() !== null
        ]);
    }

    /**
     *  @Route("/animateur/statut/{id}/supprimer", name="animateurStatut_supprimer")
     */
    public function supprimerAnimateurStatut(AnimateurStatut $animateurstatut, ObjectManager $manager)
    {
        $manager->remove($animateurstatut);
        $manager->flush();
        return $this->redirectToRoute('animateurStatut_index');
    }
    /**
     * @Route("/animateur/statut/{id}/afficher", name="animateurStatut_afficher")
     */
    public function afficherUneAnimateurStatut(AnimateurStatut $animateurstatut)
    {
        return $this->render('animateur/afficherStatut.html.twig', [
            'animateurstatut' => $animateurstatut
        ]);
    }

     /**
     *  @Route("/animateur/fonction/loadFormAnimateurFonction", name="animateurFonction_pop")
     */
    public function popAnimateurFonction(AnimateurFonction $fonction = null,AnimateurFonctionRepository $repoAnimateur, Request $request, ObjectManager $manager)
    {
        if(!$fonction){
        $fonction = new AnimateurFonction();
        }
        $form = $this->createForm(AnimateurFonctionType::class, $fonction, array('method'=>'POST'));
        $form->handleRequest($request);

        if($request->isMethod('POST')){
            $animateurfonction = $request->request->get('animateur_fonction_nom');

            $nbrs = $repoAnimateur->counter($animateurfonction);
            $nbr = $nbrs[0][1];
    
            if(strlen($animateurfonction) > 0 && $nbr === "0"){
                $fonction->setNom($animateurfonction);
                $manager->persist( $fonction );
                $manager->flush();
                $response = new Response();
                $response = JsonResponse::fromJsonString('{"id":'.$fonction->getId().', "value":"'.$fonction->getNom().'"}');
            }else{
                $response = new Response();
                $response = JsonResponse::fromJsonString('{"error":"existe"}');
            }
             return $response;
        }
        return $this->render('animateur/popFonction.html.twig', [
            'form' => $form->createView(),
        ]);
    }

     /**
     *  @Route("/animateur/statut/loadFormAnimateurStatut", name="animateurStatut_pop")
     */
    public function popAnimateurStatut(AnimateurStatut $statut = null,AnimateurStatutRepository $repoAnimateur, Request $request, ObjectManager $manager)
    {
        if(!$statut){
            $statut = new AnimateurStatut();
        }
        $form = $this->createForm(AnimateurStatutType::class, $statut, array('method'=>'POST'));
        $form->handleRequest($request);

        if($request->isMethod('POST')){
            $animateurstatut = $request->request->get('animateur_statut_nom');

            $nbrs = $repoAnimateur->counter($animateurstatut);
            $nbr = $nbrs[0][1];
    
            if(strlen($animateurstatut) > 0 && $nbr === "0"){
                $statut->setNom($animateurstatut);
                $manager->persist( $statut );
                $manager->flush();
                $response = new Response();
                $response = JsonResponse::fromJsonString('{"id":'.$statut->getId().', "value":"'.$statut->getNom().'"}');
            }else{
                $response = new Response();
                $response = JsonResponse::fromJsonString('{"error":"existe"}');
            }
             return $response;
        }
        return $this->render('animateur/popStatut.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
    * @Route("/animateur/fonction/supprAlertFormFonctionAnimateur", name="animateur_fonction_suppr_alert")
    * @IsGranted("ROLE_ADMIN")
    */
    public function supprFonction(AnimateurRepository $repoAnimateur, Request $request, ObjectManager $manager)
    {

        if($request->isMethod('POST')){

            $id = $request->request->get('id');
            
            if($id > 0){
                $nbrs = $repoAnimateur->counterFonction($id);
                $nbr = $nbrs[0][1];

                $response = new Response();
                $response = JsonResponse::fromJsonString('{"nb":'.$nbr.'}');
            } else {
                $response = new Response();
                $response = JsonResponse::fromJsonString('{"error":"notnumber"}');
            }

            return $response;
        } else {
            $response = new Response();
            $response = JsonResponse::fromJsonString('{"error":"exception"}');
        }
        
    }

    /**
    * @Route("/animateur/statut/supprAlertFormFonctionAnimateur", name="animateur_statut_suppr_alert")
    * @IsGranted("ROLE_ADMIN")
    */
    public function supprStatut(AnimateurRepository $repoAnimateur, Request $request, ObjectManager $manager)
    {

        if($request->isMethod('POST')){

            $id = $request->request->get('id');
            
            if($id > 0){
                $nbrs = $repoAnimateur->counterStatut($id);
                $nbr = $nbrs[0][1];

                $response = new Response();
                $response = JsonResponse::fromJsonString('{"nb":'.$nbr.'}');
            } else {
                $response = new Response();
                $response = JsonResponse::fromJsonString('{"error":"notnumber"}');
            }

            return $response;
        } else {
            $response = new Response();
            $response = JsonResponse::fromJsonString('{"error":"exception"}');
        }
        
    }

    /**
    * @Route("/animateur/commune", name="animateur_commune")
    */
    public function TribunalCommune(CommuneRepository $crepo, Request $request)
    {
        $commune = $request->request->get("animateur_commune_animateur");
        $communes= $crepo->findCommunes($commune);
       
        $response = new JsonResponse($communes); 

        return $response;
    }   

    /**
     * @Route("/animateur/imprimer", name="animateur_imprimer", methods={"GET"})
     */
    public function print(AnimateurRepository $repo)
    {
       
    // Configure Dompdf according to your needs
    $pdfOptions = new Options();
    $pdfOptions->set('defaultFont', 'Arial');
    
    // Instantiate Dompdf with our options
    $dompdf = new Dompdf($pdfOptions);
    $animateurs = $repo->FindAll();
    // Retrieve the HTML generated in our twig file
    $html = $this->renderView('animateur/pdf.html.twig', [
        'animateurs' => $animateurs
    ]);
    
    // Load HTML to Dompdf
    $dompdf->loadHtml($html);
    
    // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
    $dompdf->setPaper('A4', 'landscape');

    // Render the HTML as PDF
    $dompdf->render();
    $canvas = $dompdf->get_canvas();
    $date = date("d-m-Y");
    $canvas->page_text(750, 575, "Page {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));
    $canvas->page_text(50, 574, "Liste des animateurs au $date", null, 10, array(0, 0, 0));
    // Output the generated PDF to Browser (force download)
    $dompdf->stream("liste_animateurs.pdf", [
        "Attachment" => false
    ]);
}

/**
     * @Route("/animateur/{id}/imprimer", name="animateur_afficher_imprimer")
     */
    public function imprimerShowOne(Animateur $animateur, Request $request)
    {
        $pdfOptions = new Options();
    $pdfOptions->set('defaultFont', 'Arial');
    
    // Instantiate Dompdf with our options
    $dompdf = new Dompdf($pdfOptions);
   $animateur ->getId();
   
    // Retrieve the HTML generated in our twig file
    $html = $this->renderView('animateur/pdf_show.html.twig', [
        'animateur' => $animateur
    ]);
    
    // Load HTML to Dompdf
    $dompdf->loadHtml($html);
    
    // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
    $dompdf->setPaper('A4', 'landscape');

    // Render the HTML as PDF
    $dompdf->render();
    $canvas = $dompdf->get_canvas();
    $date = date("d-m-Y");
    $canvas->page_text(750, 575, "Page {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));
    $canvas->page_text(50, 574, "Détails - {$animateur} au $date", null, 10, array(0, 0, 0));
    // Output the generated PDF to Browser (force download)
    $dompdf->stream("details_animateur.pdf", [
        "Attachment" => false
    ]);
}
}