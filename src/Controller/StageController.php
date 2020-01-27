<?php

namespace App\Controller;


use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\Stage;
use App\Form\StageType;
use App\Entity\Tribunal;
use App\Entity\Animateur;
use App\Entity\LieuStage;
use App\Entity\Stagiaire;
use App\Entity\Prefecture;
use App\Form\TribunalType;
use App\Form\AnimateurType;
use App\Form\LieuStageType;
use App\Form\StagiaireType;
use App\Form\PrefectureType;
use App\Entity\Participation;
use App\Form\ParticipationType;
use App\Repository\StageRepository;
use App\Repository\CiviliteRepository;
use App\Repository\TribunalRepository;
use App\Repository\AnimateurRepository;
use App\Repository\LieuStageRepository;
use App\Repository\StagiaireRepository;
use App\Repository\InfractionRepository;
use App\Repository\PrefectureRepository;
use App\Repository\ParticipationRepository;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\AnimateurStatutRepository;
use App\Repository\TribunalServiceRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\TribunalAutoriteRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\AnimateurFonctionRepository;
use App\Repository\PrefectureServiceRepository;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PrefectureAutoriteRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin")
 * @IsGranted("ROLE_ADMIN")
 */
class StageController extends AbstractController
{
    /**
     * Index pour les stages à venir avec pagination
     * @Route("/stage", name="stage_index")
     */
    public function index(StageRepository $repo, PaginatorInterface $paginator, Request $request) 
    {
        $allStages = $repo->findAllToCome();

        $stages = $paginator->paginate(
            $allStages,
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );
        $stages ->setCustomParameters([
            'position' => 'centered',
            'size' => 'small',
            'rounded' => true,
        ]);
        return $this->render('stage/index.html.twig', [
                       'stages' => $stages
        ]);
    }
    /**
     * Index pour tous les stages (terminés et à venir) avec pagination
     * @Route("/stage/tous", name="stage_tous")
     * 
     */
    public function stageTous(StageRepository $repo, PaginatorInterface $paginator, Request $request) 
    {
        $allStagesQuery = $repo->findAllQuery();
        

        $stages = $paginator->paginate(
            $allStagesQuery,
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );
        $stages ->setCustomParameters([
            'position' => 'centered',
            'size' => 'small',
            'rounded' => true,
        ]);
        return $this->render('stage/tous.html.twig', [   
            'stages' => $stages
        ]);
    }

    //  /**
    //   * Pop-up ajouter un tribunal
    //  *  @Route("/stage/loadFormTribunal", name="stage_tribunal")
    //  */
    // public function popTribunal(Tribunal $tribunal = null, TribunalAutoriteRepository $repoAutorite, TribunalServiceRepository $repoService, TribunalRepository $repoTribunal, Request $request, ObjectManager $manager)
    // {
    //     if(!$tribunal){
    //         $tribunal = new Tribunal();
    //     }

    //     $form = $this->createForm( TribunalType::class, $tribunal, array('method'=>'POST'));
    //     $form->handleRequest( $request );

    //     if($request->isMethod('POST')){
    //         $tribunalNom = $request->request->get('tribunal_nom_tribunal');
    //         $tribunalAdresse = $request->request->get('tribunal_adresse_tribunal');
    //         $tribunalNumeroAdresse = $request->request->get('tribunal_numero_adresse_tribunal');
    //         $tribunalCommune = $request->request->get('tribunal_commune_tribunal');
    //         $tribunalAutorite = $request->request->get('tribunal_tribunal_autorite');
    //         $tribunalService = $request->request->get('tribunal_tribunal_service');
      
    //         $autorite = $repoAutorite->find($tribunalAutorite);
    //         $service = $repoService->find($tribunalService);

    //          $nbrs = $repoTribunal->counter($tribunalNom,$tribunalCommune);
    //          $nbr = $nbrs[0][1];

    //         if(strlen($tribunalNom) > 0 && strlen($tribunalAdresse) > 0 && strlen($tribunalNumeroAdresse) > 0 &&
    //             strlen($tribunalCommune) > 0 && strlen($tribunalAutorite) > 0 && strlen($tribunalService) > 0 && $nbr === "0"){
                
    //             $tribunal->setNomTribunal($tribunalNom);
    //             $tribunal->setAdresseTribunal($tribunalAdresse);
    //             $tribunal->setNumeroAdresseTribunal($tribunalNumeroAdresse);
    //             $tribunal->setCommuneTribunal($tribunalCommune);
    //             $tribunal->setTribunalService($service);
    //             $tribunal->setTribunalAutorite($autorite);

    //             $manager->persist( $tribunal );
    //             $manager->flush();

    //             $response = new Response();
    //             $response = JsonResponse::fromJsonString('{"id":'.$tribunal->getId().', "value":"'.$tribunal->getNomTribunal().'"}');
    //         }else{
    //             $response = new Response();
    //             $response = JsonResponse::fromJsonString('{"error":"existe"}');
    //         }
    //         return $response;
    //     }        
    //     return $this->render('stage/popTribunal.html.twig', 
    //         ['form' => $form->createView()
    //         ]);
    // }

    //  /**
    //   * Pop-up ajouter une prefecture
    //  *  @Route("/stage/loadFormPrefecture", name="stage_prefecture")
    //  */
    // public function popPrefecture(Prefecture $prefecture = null,PrefectureRepository $repoPrefecture,PrefectureAutoriteRepository $repoAutorite,PrefectureServiceRepository $repoService, Request $request, ObjectManager $manager)
    // {
    //     if(!$prefecture){
    //         $prefecture = new Prefecture();
    //     }

    //     $form = $this->createForm( PrefectureType::class, $prefecture, array('method'=>'POST'));
    //     $form->handleRequest( $request );

    //     if($request->isMethod('POST')){
          
    //         $prefectureNom = $request->request->get('prefecture_nomPrefecture');
    //         $prefectureAdresse = $request->request->get('prefecture_adressePrefecture');
    //         $prefectureNumeroAdresse = $request->request->get('prefecture_numeroAdressePrefecture');
    //         $prefectureCommune = $request->request->get('prefecture_communePrefecture');
    //         $prefectureAutorite = $request->request->get('prefecture_prefectureAutorite');
    //         $prefectureService = $request->request->get('prefecture_prefectureService');

    //         $autorite = $repoAutorite->find($prefectureAutorite);
    //         $service = $repoService->find($prefectureService);
    //         // dump($autorite);
    //         // die();
    //         $nbrs = $repoPrefecture->counter($prefectureNom,$prefectureCommune);
    //         $nbr = $nbrs[0][1];
            
    //         if(strlen($prefectureNom) > 0 && strlen($prefectureAdresse) > 0 && strlen($prefectureNumeroAdresse) > 0 &&
    //             strlen($prefectureCommune) > 0 && strlen($prefectureAutorite) > 0 &&
    //             strlen($prefectureService) > 0 && $nbr === "0"){
    //             $prefecture->setNomPrefecture($prefectureNom);
    //             $prefecture->setAdressePrefecture($prefectureAdresse);
    //             $prefecture->setNumeroAdressePrefecture($prefectureNumeroAdresse);
    //             $prefecture->setCommunePrefecture($prefectureCommune);
    //             $prefecture->setPrefectureService($service);
    //             $prefecture->setPrefectureAutorite($autorite);

    //             $manager->persist($prefecture);
    //             $manager->flush();

    //             $response = new Response();
    //             $response = JsonResponse::fromJsonString('{"id":'.$prefecture->getId().', "value":"'.$prefecture->getNomPrefecture().'"}');
    //         }else{
    //             $response = new Response();
    //             $response = JsonResponse::fromJsonString('{"error":"existe"}');
    //         }      
    //         return $response;
    //     }  
    //     return $this->render('stage/popPrefecture.html.twig', 
    //         ['form' => $form->createView()
    //         ]);
    // }


     /**
      * Pop-up ajouter un stagiaire
     *  @Route("/stage/loadFormStagiaire", name="stage_stagiaire")
     */
    public function popStagiaire(Stagiaire $stagiaire = null, CiviliteRepository $repoCivilite, StagiaireRepository $repoStagiaire, Request $request, ObjectManager $manager)
    {
        if(!$stagiaire){
            $stagiaire = new Stagiaire();
        }

        $form = $this->createForm( StagiaireType::class, $stagiaire, array('method'=>'POST'));
        $form->handleRequest( $request );

        if($request->isMethod('POST')){
           
            $stagiaireNom = $request->request->get('stagiaire_nomStagiaire');
            $stagiairePrenom = $request->request->get('stagiaire_prenomStagiaire');
            $stagiaireCommune = $request->request->get('stagiaire_communeStagiaire');
            $stagiaireNomNaissance = $request->request->get('stagiaire_nomNaissanceStagiaire');
            $stagiaireDateNaissance = $request->request->get('stagiaire_dateNaissanceStagiaire');
            $stagiaireLieuNaissance = $request->request->get('stagiaire_lieuNaissanceStagiaire');
            $stagiaireAdresse = $request->request->get('stagiaire_adresseStagiaire');
            $stagiaireNationalite = $request->request->get('stagiaire_nationaliteStagiaire');
            $stagiaireNumeroPortable = $request->request->get('stagiaire_numeroPortableStagiaire');
            $stagiaireNumeroFixe = $request->request->get('stagiaire_numeroFixeStagiaire');
            $stagiaireNumeroAdresse = $request->request->get('stagiaire_numeroAdresseStagiaire');
            $stagiaireEmail = $request->request->get('stagiaire_emailStagiaire');
            $stagiaireCivilite = $request->request->get('stagiaire_civilite');
        
            $year = substr($stagiaireDateNaissance, 0, 10);
            $date = (\DateTime::createFromFormat('Y-m-d', $year));

            $civilite = $repoCivilite->find($stagiaireCivilite);

            $nbrs = $repoStagiaire->counter($stagiaireNom,$stagiairePrenom,$year);
            $nbr = $nbrs[0][1];
    
            if(strlen($stagiaireNom) > 0 && strlen($stagiairePrenom) > 0 &&
                strlen($stagiaireCommune) > 0 && strlen($stagiaireNomNaissance) > 0 && strlen($stagiaireDateNaissance) != "" &&
                strlen($stagiaireLieuNaissance) > 0 && strlen($stagiaireAdresse) > 0 && strlen($stagiaireNationalite) > 0 &&
                strlen($stagiaireNumeroPortable) > 0 && strlen($stagiaireNumeroFixe) > 0 && strlen($stagiaireEmail) > 0 &&
                strlen($stagiaireNumeroAdresse) > 0 && strlen($stagiaireCivilite) > 0 && $nbr === "0"){

                $stagiaire->setNomStagiaire($stagiaireNom);
                $stagiaire->setPrenomStagiaire($stagiairePrenom);
                $stagiaire->setCommuneStagiaire($stagiaireCommune);
                $stagiaire->setNomNaissanceStagiaire($stagiaireNomNaissance);
                $stagiaire->setLieuNaissanceStagiaire($stagiaireLieuNaissance);
                $stagiaire->setAdresseStagiaire($stagiaireAdresse);
                $stagiaire->setNationaliteStagiaire($stagiaireNationalite);
                $stagiaire->setNumeroPortableStagiaire($stagiaireNumeroPortable);
                $stagiaire->setNumeroFixeStagiaire($stagiaireNumeroFixe);
                $stagiaire->setNumeroAdresseStagiaire($stagiaireNumeroAdresse);
                $stagiaire->setEmailStagiaire($stagiaireEmail);
                
                $stagiaire->setDateNaissanceStagiaire($date);
                $stagiaire->setCivilite($civilite);
               
                $manager->persist($stagiaire);
                $manager->flush();

                $response = new Response();
                $response = JsonResponse::fromJsonString('{"id":'.$stagiaire->getId().', "value":"'.$stagiaire->getPrenomStagiaire().'"}');
            }else{
                $response = new Response();
                $response = JsonResponse::fromJsonString('{"error":"existe"}');
            }      
            return $response;
        }  
        return $this->render('stage/popStagiaire.html.twig', 
            ['form' => $form->createView()
            ]);
    }


    /**
     * Pop-up ajouter un animateur
    *  @Route("/stage/loadFormAnimateur", name="stage_animateur")
    */
    public function popAnimateur(Animateur $animateur = null, AnimateurFonctionRepository $repoFonction, AnimateurStatutRepository $repoStatut, CiviliteRepository $repoCivilite, AnimateurRepository $repoAnimateur, Request $request, ObjectManager $manager)
    {
        if(!$animateur){
            $animateur = new Animateur();
        }

        $form = $this->createForm( AnimateurType::class, $animateur, array('method'=>'POST'));
        $form->handleRequest( $request );

        if($request->isMethod('POST')){
           

            $animateurNom = $request->request->get('animateur_nom_animateur');
            $animateurPrenom = $request->request->get('animateur_prenom_animateur');
            $animateurRue = $request->request->get('animateur_rue_animateur');
            $animateurNumeroRue = $request->request->get('animateur_numero_rue_animateur');
            $animateurCommune = $request->request->get('animateur_commune_animateur');
            $animateurRegion = $request->request->get('animateur_region_animateur');
            $animateurEmail = $request->request->get('animateur_email_animateur');
            $animateurNumeroPortable = $request->request->get('animateur_numero_portable_animateur');
            $animateurNumeroFixe = $request->request->get('animateur_numero_fixe_animateur');
            $animateurSiret = $request->request->get('animateur_siret_animateur');
            $animateurUrssaf = $request->request->get('animateur_urssaf_animateur');
            $animateurRaisonSociale = $request->request->get('animateur_raison_sociale_animateur');
            $animateurGta = $request->request->get('animateur_gta_animateur');
            $animateurCivilite = $request->request->get('animateur_civilite');
            $animateurFonction = $request->request->get('animateur_animateurFonction');
            $animateurStatut = $request->request->get('animateur_animateurStatut');
            $animateurObservations = $request->request->get('animateur_observations_animateur');
        

            $civilite = $repoCivilite->find($animateurCivilite);
            $fonction = $repoFonction->find($animateurFonction);
            $statut = $repoStatut->find($animateurStatut);

          
            $nbrs = $repoAnimateur->counter($animateurNom,$animateurPrenom,$animateurSiret);
            $nbr = $nbrs[0][1];
          
    
            if(strlen($animateurNom) > 0 && strlen($animateurCivilite) != "0" && strlen($animateurPrenom) > 0 &&
                strlen($animateurRue) > 0 && strlen($animateurCommune) > 0 && strlen($animateurNumeroRue) > 0 &&
                strlen($animateurRegion) > 0 && strlen($animateurSiret) > 0 && strlen($animateurUrssaf) > 0 &&
                strlen($animateurNumeroFixe) > 0 &&strlen($animateurRaisonSociale) > 0 && strlen($animateurGta) != "0" 
                && strlen($animateurFonction) != "0" && strlen($animateurStatut) != "0" && $nbr === "0"){

                $animateur->setNomAnimateur($animateurNom);
                $animateur->setPrenomAnimateur($animateurPrenom);
                $animateur->setRaisonSocialeAnimateur($animateurRaisonSociale);
                $animateur->setGtaAnimateur($animateurGta);
                $animateur->setCommuneAnimateur($animateurCommune);
                $animateur->setRegionAnimateur($animateurRegion);
                $animateur->setNumeroRueAnimateur($animateurNumeroRue);
                $animateur->setRueAnimateur($animateurRue);
                $animateur->setNumeroPortableAnimateur($animateurNumeroPortable);
                $animateur->setNumeroFixeAnimateur($animateurNumeroFixe);
                $animateur->setEmailAnimateur($animateurEmail);
                $animateur->setUrssafAnimateur($animateurUrssaf);

                $animateur->setSiretAnimateur($animateurSiret);
                $animateur->setObservationsAnimateur($animateurObservations);
                $animateur->setAnimateurStatut($statut);
                $animateur->setAnimateurFonction($fonction);
                $animateur->setCivilite($civilite);

                $manager->persist($animateur);
                $manager->flush();

                $response = new Response();
                $response = JsonResponse::fromJsonString('{"id":'.$animateur->getId().', "value":"'.$animateur->getPrenomAnimateur().'"}');
            }else{
                $response = new Response();
                $response = JsonResponse::fromJsonString('{"error":"existe"}');
            }      
            return $response;
        }  
        return $this->render('stage/popAnimateur.html.twig', 
            ['form' => $form->createView()
            ]);
    }

    /**
     * Pop-up ajouter un lieu de stage
    *  @Route("/stage/loadFormLieuStage", name="stage_lieu")
    */
    public function popLieuStage(LieuStage $lieuStage = null, LieuStageRepository $repoLieu, Request $request, ObjectManager $manager)
    {
        if(!$lieuStage){
            $lieuStage = new LieuStage();
        }

        $form = $this->createForm( LieuStageType::class, $lieuStage, array('method'=>'POST'));
        $form->handleRequest( $request );

        if($request->isMethod('POST')){
           

            $lieuStageNom = $request->request->get('lieu_stage_nom_etablissement');
            $lieuStageAgrement = $request->request->get('lieu_stage_agrement');
            $lieuStageNumeroAdresse = $request->request->get('lieu_stage_numero_adresse_stage');
            $lieuStageAdresse = $request->request->get('lieu_stage_adresse_stage');
            $lieuStageCommune = $request->request->get('lieu_stage_nom_commune');
            $lieuStageLatitude = $request->request->get('lieu_stage_latitude');
            $lieuStageLongitude= $request->request->get('lieu_stage_longitude');
            $lieuStageDmsLatitude = $request->request->get('lieu_stage_dmsLatitude');
            $lieuStageDmsLongitude= $request->request->get('lieu_stage_dmsLongitude');
            $lieuStageTelephone = $request->request->get('lieu_stage_telephone_stage');
                        
            $nbrs = $repoLieu->counter($lieuStageNom,$lieuStageAgrement);
            $nbr = $nbrs[0][1];
    
            if(strlen($lieuStageNom) > 0 && strlen($lieuStageAgrement) > 0 && strlen($lieuStageNumeroAdresse) > 0 &&
            strlen($lieuStageAdresse) > 0 && strlen($lieuStageCommune) > 0 && strlen($lieuStageTelephone) > 0 && $nbr === "0"){

                $lieuStage->setNomEtablissement($lieuStageNom);
                $lieuStage->setAgrement($lieuStageAgrement);
                $lieuStage->setAdresseStage($lieuStageAdresse);
                $lieuStage->setNumeroAdresseStage($lieuStageNumeroAdresse);
                $lieuStage->setNomCommune($lieuStageCommune);
                $lieuStage->setLatitude($lieuStageLatitude);
                $lieuStage->setLongitude($lieuStageLongitude);
                $lieuStage->setDmsLatitude($lieuStageDmsLatitude);
                $lieuStage->setDmsLongitude($lieuStageDmsLongitude);
                $lieuStage->setTelephoneStage($lieuStageTelephone);
dump($lieuStageLatitude);
die();

                $manager->persist($lieuStage);
                var_dump($lieuStage);
                die();
                $manager->flush();

                $response = new Response();
                $response = JsonResponse::fromJsonString('{"id":'.$lieuStage->getId().', "value":"'.$lieuStage->getNomEtablissement().'"}');
            }else{
                $response = new Response();
                $response = JsonResponse::fromJsonString('{"error":"existe"}');
            }      
            return $response;
        }  
        return $this->render('stage/popLieuStage.html.twig', 
            ['form' => $form->createView()
            ]);
    }


    /**
     *  @Route("/stage/ajouter", name="stage_ajouter")
     *  @Route("/stage/{id}/modifier", name="stage_modifier")
     */
    public function stageForm(Stage $stage = null, ParticipationRepository $prepo, Request $request, ObjectManager $manager)
    {
        if(!$stage){
        $stage = new Stage();
       
        }
        $date = date("d-m-Y H:i");
        $form = $this->createForm(StageType::class, $stage);
        $form->handleRequest($request);
        
        
        if($form->isSubmitted() && $form->isValid()){
           // Ajout des stagiaires au stage
            // On parcours les stagiaires sélectionnés
            foreach($form->get('stagiaire')->getData() as $s)
            {
                if(!$stage->getStagiaire()->contains($s))
                {
                    // On ajoute ce stagiaire
                    $participation = new Participation();
                    $participation->setStage($stage);
                    $participation->setStagiaire($s);
                    $stage->addParticipation($participation);
                }
            }

            // Suppression des stagiaires au stage
            // On parcours les stagiaires de la DBforeach
                foreach($stage->getStagiaire() as $s)
            {
                if(!$form->get('stagiaire')->getData()->contains($s))
                { 
            // On supprime ce stagiaire
                    $oldParticipations = $prepo->findOneBy(array('stage' => $stage->getId(),'stagiaire' => $s->getId()));
                                      
                    $manager->remove($oldParticipations);                     
                    $manager->flush();
           
                }
            }
            
            $manager->persist($stage);
            $manager->flush();
           
                        
            return $this->redirectToRoute('stage_index');
        }
        return $this->render('stage/ajouter.html.twig', [
            'formStage' => $form->createView(),
            'editMode' => $stage->getId() !== null,
            $stage->getDated() > $date
        ]);
    }
    /**
     *  @Route("/stage/{id}/supprimer", name="stage_supprimer")
     */
    public function delete(Stage $stage, ObjectManager $manager)
    {
        $date = date("d-m-Y");
        if ($stage->getDated() > $date) { 
       
        return $this->redirectToRoute('stage_index');
    }}
    /**
     * @Route("/stage/{id}/afficher", name="stage_afficher")
     */
    public function showOne(Stage $stage)
    {
        return $this->render('stage/afficher.html.twig', [
            'stage' => $stage
        ]);
    }

    /**
    * @Route("/stage/lieuStage/supprAlertFormLieuStage", name="stage_lieu_suppr_alert")
    * @IsGranted("ROLE_ADMIN")
    */
    public function supprLieu(StageRepository $repoStage, Request $request, ObjectManager $manager)
    {

        if($request->isMethod('POST')){

            $id = $request->request->get('id');
            
            if($id > 0){
                $nbrs = $repoStage->counterLieu($id);
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
 * Options PDF
 */

    /**
     * @Route("/stage/imprimer", name="stage_imprimer", methods={"GET"})
     */
    public function print(StageRepository $repo)
    {
       
    // Configure Dompdf according to your needs
    $pdfOptions = new Options();
    $pdfOptions->set('defaultFont', 'Arial');
    
    // Instantiate Dompdf with our options
    $dompdf = new Dompdf($pdfOptions);
    $stages = $repo->findAllToCome();
    // Retrieve the HTML generated in our twig file
    $html = $this->renderView('stage/pdf.html.twig', [
        'stages' => $stages
    ]);
    // Load HTML to Dompdf
    $dompdf->loadHtml($html);
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
    $dompdf->setPaper('A4', 'landscape');
    // Render the HTML as PDF
    $dompdf->render();
    // add the header
    $canvas = $dompdf->get_canvas();
    $date = date("d-m-Y");
    $canvas->page_text(750, 575, "Page {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));
    $canvas->page_text(50, 574, "Liste des stages à venir au $date", null, 10, array(0, 0, 0));
    // Output the generated PDF to Browser (force download)
    $dompdf->stream("liste_stages.pdf", [
        "Attachment" => false
    ]);
}
    

    /**
     * @Route("/stage/tous_imprimer", name="stage_tous_imprimer", methods={"GET"})
     */
    public function printAll(StageRepository $repo)
    {
       
    // Configure Dompdf according to your needs
    $pdfOptions = new Options();
    $pdfOptions->set('defaultFont', 'Arial');
    
    // Instantiate Dompdf with our options
    $dompdf = new Dompdf($pdfOptions);
    $stages = $repo->findAll();
    // Retrieve the HTML generated in our twig file
    $html = $this->renderView('stage/pdf_tous.html.twig', [
        'stages' => $stages
    ]);
    // Load HTML to Dompdf
    $dompdf->loadHtml($html);
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
    $dompdf->setPaper('A4', 'landscape');
    // Render the HTML as PDF
    $dompdf->render();
    // add the header
    $canvas = $dompdf->get_canvas();
    $date = date("d-m-Y");
    $canvas->page_text(750, 575, "Page {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));
    $canvas->page_text(50, 574, "Liste des stages au $date", null, 10, array(0, 0, 0));
    // Output the generated PDF to Browser (force download)
    $dompdf->stream("liste_stages_tous.pdf", [
        "Attachment" => false
    ]);
}

/**
    * PDF émargement stage
     * @Route("/stage/{id}/emargement", name="stage_emargement")
     */
    public function emargement(stage $stage, Request $request, ObjectManager $manager)
    {
    $pdfOptions = new Options();
    $pdfOptions->set('defaultFont', 'Arial');
    
    // Instantiate Dompdf with our options
    $dompdf = new Dompdf($pdfOptions);
    $stage ->getId();
  
    
    dump($stage);
    die();
    // Retrieve the HTML generated in our twig file
    $html = $this->renderView('stage/pdf_emargement.html.twig', [
        'stage' => $stage,
        
    ]);
     // Load HTML to Dompdf
     $dompdf->loadHtml($html);
    
     // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
     $dompdf->setPaper('A4', 'portrait');
 
     // Render the HTML as PDF
     $dompdf->render();
     $canvas = $dompdf->get_canvas();
     //$date = date("d-m-Y");
     // $canvas->page_text(450, 80, "Besançon, le $date", null, 10, array(0, 0, 0));
     $canvas->page_text(120, 780, "Association Franc-comtoise d’Education Routière – 7 Square Saint Amour 25000 Besançon", null, 10, array(.4, .4, .8));
     $canvas->page_text(200, 790, "Tél : 06 24 18 32 41 – Courriel : afer.wnr@gmail.com", null, 10, array(.4, .4, .8));
     $canvas->page_text(240, 800, "N° de SIRET : 820 306 165 00011", null, 10, array(.4, .4, .8));
     $canvas->page_text(210, 810, "N° de Formation Professionnelle : 27 25 03054 25", null, 10, array(.4, .4, .8));
     // Output the generated PDF to Browser (force download)
     $dompdf->stream("emargement_{$stage}.pdf", [
         "Attachment" => false
     ]);
 }

 /**
    * PDF bordereau stage
     * @Route("/stage/{id}/bordereau", name="stage_bordereau")
     */
    public function bordereau(StageRepository $repo, Stage $stage, Request $request, ObjectManager $manager)
    {
    $pdfOptions = new Options();
    $pdfOptions->set('defaultFont', 'Arial');
    
    // Instantiate Dompdf with our options
    $dompdf = new Dompdf($pdfOptions);
    $stage ->getId();
    $stagiaires = $repo->bordereau();
    //dump($stage);
    //die();
    // Retrieve the HTML generated in our twig file
    $html = $this->renderView('stage/pdf_bordereau.html.twig', [
        'stage' => $stage,
        'stagiaires' => $stagiaires,
    ]);
     // Load HTML to Dompdf
     $dompdf->loadHtml($html);
    
     // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
     $dompdf->setPaper('A4', 'portrait');
 
     // Render the HTML as PDF
     $dompdf->render();
     $canvas = $dompdf->get_canvas();
     $date = date("d-m-Y");
     $canvas->page_text(450, 80, "Besançon, le $date", null, 10, array(0, 0, 0));
     $canvas->page_text(120, 780, "Association Franc-comtoise d’Education Routière – 7 Square Saint Amour 25000 Besançon", null, 10, array(.4, .4, .8));
     $canvas->page_text(200, 790, "Tél : 06 24 18 32 41 – Courriel : afer.wnr@gmail.com", null, 10, array(.4, .4, .8));
     $canvas->page_text(240, 800, "N° de SIRET : 820 306 165 00011", null, 10, array(.4, .4, .8));
     $canvas->page_text(210, 810, "N° de Formation Professionnelle : 27 25 03054 25", null, 10, array(.4, .4, .8));
     // Output the generated PDF to Browser (force download)
     $dompdf->stream("bordereau_{$stage}.pdf", [
         "Attachment" => false
     ]);
 }
}