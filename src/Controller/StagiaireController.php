<?php

namespace App\Controller;

use Dompdf\Dompdf;
use App\Entity\Cas;
use Dompdf\Options;
use App\Entity\Stage;
use App\Entity\Licence;
use App\Entity\Avantage;
use App\Entity\Stagiaire;
use App\Form\LicenceType;
use App\Entity\Infraction;
use App\Form\AvantageType;
use App\Form\StagiaireType;
use App\Form\InfractionType;
use App\Entity\Participation;
use Faker\Provider\ka_GE\DateTime;
use App\Repository\CommuneRepository;
use App\Repository\LicenceRepository;
use App\Repository\AvantageRepository;
use App\Repository\StagiaireRepository;
use App\Repository\InfractionRepository;
use App\Repository\PrefectureRepository;
use App\Repository\ParticipationRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\NatureInfractionRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
/**
 * @Route("/admin")
 */
class StagiaireController extends AbstractController
{
    /**
     * @Route("/stagiaire", name="stagiaire_index")
     * avec barre de recherche et pagination
     */
   
    public function index(StagiaireRepository $repo, PaginatorInterface $paginator, Request $request) 
    {
       
        $s = $request->query->get('q');
        $allstagiaires = $repo->findAllWithSearch($s);
        
        $stagiaires = $paginator->paginate(
            $allstagiaires, 
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );
    
        $stagiaires ->setCustomParameters([
            'position' => 'centered',
            'size' => 'small',
            'rounded' => true,
        ]);
       
        return $this->render('stagiaire/index.html.twig', [
           
            'stagiaires' => $stagiaires,
            
        ]);
    }
    /**
     *  @Route("/stagiaire/ajouter", name="stagiaire_ajouter")
     *  @Route("/stagiaire/{id}/modifier", name="stagiaire_modifier")
     *  @IsGranted("ROLE_ADMIN")
     */
    public function stagiaireForm(Stagiaire $stagiaire = null, Participation $participation = null, ParticipationRepository $prepo, StagiaireRepository $repoStagiaire, Request $request, ObjectManager $manager)
    {
        if(!$stagiaire){
           $stagiaire = new stagiaire();
        }
        
           $form = $this->createForm(stagiaireType::class, $stagiaire);
           $form->handleRequest($request);
           if($form->isSubmitted() && $form->isValid()){
            // Ajout des stages du stagiaire
            // On parcours les stages sélectionnés
                        
            foreach ($form->get('stage')->getData() as $s)
            { 
                
                if(!$stagiaire->getStage()->contains($s))
                {   
                    $participation = new Participation();
                    // On ajoute ce stage
                    $participation->setStagiaire($stagiaire);
                    $participation->setStage($s);
                    $stagiaire->addParticipation($participation); 
                                    
                }
            }       

                        // Ajout des cas du stagiaire
            // On parcours les cas sélectionnés
            foreach($form->get('cas')->getData() as $c)
            {   
                if(!$stagiaire->getCas()->contains($c))
                {
                    if(!$participation){
                    $participation = new Participation();
                    }   
                        $participation->setStagiaire($stagiaire);
                        $participation->setCas($c);    
                        $stagiaire->addParticipation($participation);    
                    }
            }
            //Suppression des stages du stagiaire
             //On parcours les stages de la DB
             foreach($stagiaire->getStage() as $s)
             {
                 if(!$form->get('stage')->getData()->contains($s))
                 {  
                 // On supprime ce stage
                     $oldParticipation = $prepo->findOneBy(array('stagiaire' => $stagiaire->getId(),'stage' => $s->getId()));
                    
                       $manager->remove($oldParticipation);                     
                       $manager->flush();
            
                 }
             } 
            
            //Suppression des cas du stagiaire
            //On parcours les cas de la DB  
            foreach($stagiaire->getCas() as $cas)
            {
                if(!$form->get('cas')->getData()->contains($cas))
                {  
                // On supprime ce cas
                    $oldParticipation = $prepo->findOneBy(array('stagiaire' => $stagiaire->getId(),'cas' => $cas->getId()));
                   
                    $manager->remove($oldParticipation);                     
                    $manager->flush();
                }
            }

            $stagiaireNom = $stagiaire->getNomStagiaire();
            $stagiairePrenom = $stagiaire->getPrenomStagiaire();
            $stagiaireDateNaissance = $stagiaire->getDateNaissanceStagiaire();
            $nbrs = $repoStagiaire->counter($stagiaireNom,$stagiairePrenom,$stagiaireDateNaissance);
            $nbr = $nbrs[0][1];
      
            if($stagiaire->getId() === null && $nbr === "0"){
                $manager->persist($stagiaire);
                $manager->flush();
                
            }else if($stagiaire->getId() !== null){
                $manager->persist($stagiaire);
                $manager->flush();
            }else{
                return $this->render('stagiaire/ajouter.html.twig', [
                    
                    'formStagiaire' => $form->createView(),
                    'editMode' => $stagiaire->getId() !== null,
                    'stagiaire' => $stagiaire, 
                    
                        
                    'error' => 'error'
                ]);
            }
            return $this->redirectToRoute('stagiaire_index');
        }
       
        return $this->render('stagiaire/ajouter.html.twig', [
            'formStagiaire' => $form->createView(),
            'editMode' => $stagiaire->getId() !== null,
            'stagiaire' => $stagiaire,
               
        ]);  
    }
    
    /**
     *  @Route("/stagiaire/{id}/supprimer", name="stagiaire_supprimer")
     *  @IsGranted("ROLE_ADMIN")
     */
    public function delete(Stagiaire $stagiaire, ObjectManager $manager)
    {
        $manager->remove($stagiaire);
        $manager->flush();
        return $this->redirectToRoute('stagiaire_index');
    }

    /**
     * @Route("/stagiaire/{id}/afficher", name="stagiaire_afficher")
     */
    public function showOne(Stagiaire $stagiaire)
    {
        return $this->render('stagiaire/afficher.html.twig', [
            'stagiaire' => $stagiaire,
            
        ]);
    }

    /**
    * @Route("/stagiaire/communeStagiaire", name="stagiaire_commune")
    */
    public function StagiaireCommune(CommuneRepository $crepo, Request $request)
    {
        $commune = $request->request->get("stagiaire_communeStagiaire"); 
        $communes= $crepo->findCommunes($commune);   
        $response = new JsonResponse($communes); 

        return $response;
    }

    


    /**
     * @Route("/stagiaire/avantage", name="avantage_index")
     */
    public function avantageIndex(AvantageRepository $arepo)
    {
        $avantage = $arepo->findAll();
        return $this->render('stagiaire/avantage/index.html.twig', [
            'avantage' => $avantage,
        ]);
    }

     /**
     *  @Route("/stagiaire/avantage/ajouter", name="avantage_ajouter")
     *  @Route("/stagiaire/avantage/{id}/modifier", name="avantage_modifier")
     */
    public function avantageForm(Avantage $avantage = null, Request $request, ObjectManager $manager)
    {
        if(!$avantage){
        $avantage = new avantage();
        }
        $form = $this->createForm(AvantageType::class, $avantage);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
        
            $manager->persist($avantage);
            $manager->flush();
            return $this->redirectToRoute('avantage_index');
        }
        return $this->render('stagiaire/avantage/ajouter.html.twig', [
            'formAvantage' => $form->createView(),
            'editMode' => $avantage->getId() !== null
        ]);
    }

    

/**Permis de conduire */

    /**
    *  @Route("/stagiaire/loadFormLicence", name="stagiaire_licence")
    */
    public function popLicence(Licence $licence = null, LicenceRepository $repoLicence, PrefectureRepository $repoPrefecture, Request $request, ObjectManager $manager)
    {
        if(!$licence){
            $licence = new Licence();
        }

        $form = $this->createForm( LicenceType::class, $licence, array('method'=>'POST'));
        $form->handleRequest( $request );

        if($request->isMethod('POST')){
            
            $licenceNumber = $request->request->get('licence_licenceNumber');
            $licenceDate = $request->request->get('licence_licenceDate');
           
            $prefecture = $request->request->get('licence_prefecture');
           
            $year = substr($licenceDate, 0, 10);
            $date = (\DateTime::createFromFormat('Y-m-d', $year));

            $prefecture = $repoPrefecture->find($prefecture);

            $nbrs = $repoLicence->counter($licenceNumber,$year);
            $nbr = $nbrs[0][1];
    
            if(strlen($licenceNumber) > 0 && strlen($licenceDate) != "" && strlen($prefecture) > 0  && $nbr === "0"){

                $licence->setLicenceNumber($licenceNumber);
                $licence->setLicenceDate($date);
                $licence->setPrefecture($prefecture);
              
                $manager->persist($licence);
              
                $manager->flush();

                $response = new Response();
                $response = JsonResponse::fromJsonString('{"id":'.$licence->getId().', "value":"'.$licence->getLicenceNumber().'"}');
               
            }else{
                $response = new Response();
                $response = JsonResponse::fromJsonString('{"error":"existe"}');
            }      
            return $response;
            
        }  
        return $this->render('stagiaire/popLicence.html.twig', 
            ['form' => $form->createView()
            ]);
    }

    /**
     * 
     * @Route("/stagiaire/permis", name="stagiaire_permis_index")
     */
    public function permisIndex(StagiaireRepository $repo, PaginatorInterface $paginator, LicenceRepository $lRepo, PrefectureRepository $pRepo, Request $request) :Response
    {
      
        
        $licence = $lRepo->findAll();
        $prefecture = $pRepo->findAll();
        $s = $request->query->get('q');
        $allstagiaires = $repo->findAllWithSearch($s);
          

        $stagiaires = $paginator->paginate(
            $allstagiaires,
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );
    
        $stagiaires ->setCustomParameters([
            'position' => 'centered',
            'size' => 'small',
            'rounded' => true,
        ]);
       

        return $this->render('stagiaire/permis.html.twig', [
           
            'stagiaires' => $stagiaires,
            'licence' => $licence,
            'prefecture' => $prefecture
           
        ]);
    }

  
     /**
     *  @Route("/stagiaire/licence/ajouter", name="licence_ajouter")
     *  @Route("/stagiaire/licence/{id}/modifier", name="licence_modifier")
     */
    public function licenceForm(Licence $licence = null, LicenceRepository $repoLicence, Request $request, ObjectManager $manager)
    {
            if(!$licence){
            $licence = new licence();
            }
            
            $form = $this->createForm(LicenceType::class, $licence);
            $form->handleRequest($request);
            
            if($form->isSubmitted() && $form->isValid()){

                $licenceNumber = $licence->getLicenceNumber();
                $licenceDate = $licence->getLicenceDate();
                $prefecture = $licence->getPrefecture();
                $nbrs = $repoLicence->counter($licenceNumber,$licenceDate,$prefecture);
                $nbr = $nbrs[0][1];
          
                if($licence->getId() === null && $nbr === "0"){
                    $manager->persist($licence);
                    $manager->flush();
                }else if($licence->getId() !== null){
                    $manager->persist($licence);
                    $manager->flush();
                }else{
                    return $this->render('stagiaire/licence/modifier.html.twig', [
                        
                        'formLicence' => $form->createView(),
                        'edit' => $licence->getId() !== null,
                        'licence' => $licence,
                        'error' => 'error'
                    ]);
                }
                return $this->redirectToRoute('stagiaire_permis_index');
            }
        
            return $this->render('stagiaire/licence/modifier.html.twig', [
                'formLicence' => $form->createView(),
                'edit' => $licence->getId() !== null,
                'licence' => $licence,
               
                'error' => 'error'
                ]);
            }
        
    /**
     *  @Route("/stagiaire/licence/{id}/supprimer", name="licence_supprimer")
     */
    public function licenceDelete(Licence $licence, ObjectManager $manager)
    {
        $manager->remove($licence);
        $manager->flush();
        return $this->redirectToRoute('stagiaire/licence_index');
    }
    

/**Infraction */

    /**
    *  @Route("/stagiaire/loadFormInfraction", name="stagiaire_infraction")
    */
    public function popInfraction(Infraction $infraction = null, InfractionRepository $repoInfraction, NatureInfractionRepository $repoNature, Request $request, ObjectManager $manager)
    {
        if(!$infraction){
            $infraction = new Infraction();
        }

        $form = $this->createForm( InfractionType::class, $infraction, array('method'=>'POST'));
        $form->handleRequest( $request );

        if($request->isMethod('POST')){
            
            $lieuInfraction = $request->request->get('infraction_lieuInfraction');
            $dateInfraction = $request->request->get('infraction_dateInfraction');
            $natureInfraction = $request->request->get('infraction_natureInfraction');
            $dateCondamnation = $request->request->get('infraction_dateCondamnation');
            $numeroParquet = $request->request->get('infraction_numeroParquet');
            $tribunal = $request->request->get('infraction_tribunal');


            $year = substr($dateInfraction, 0, 16);
            $format = 'd-m-Y H:i';
            $date = (\DateTime::createFromFormat($format, $year));
            $yearcond = substr($dateCondamnation, 0, 10);
            $datecond = (\DateTime::createFromFormat('d-m-Y', $yearcond));
           
            $natureInfraction = $repoNature->find($natureInfraction);

            $nbrs = $repoInfraction->counter($lieuInfraction, $year);
            $nbr = $nbrs[0][1];
    
            if(strlen($lieuInfraction) > 0 && strlen($dateInfraction) != "" && strlen($natureInfraction) > 0  && $nbr === "0"){

                $infraction->setLieuInfraction($lieuInfraction);
                $infraction->setDateInfraction($date);
                $infraction->setNatureInfraction($natureInfraction);
                $infraction->setDateInfraction($datecond);
                $infraction->setNumeroParquet($numeroParquet);
                $infraction->setTribunal($tribunal);
              
                $manager->persist($infraction);
                $manager->flush();

                $response = new Response();
                $response = JsonResponse::fromJsonString('{"id":'.$infraction->getId().', "value":"'.$infraction->getLieuInfraction().'"}');
               
            }else{
                $response = new Response();
                $response = JsonResponse::fromJsonString('{"error":"existe"}');
            }      
            return $response;
            
        }  
        return $this->render('stagiaire/popInfraction.html.twig', 
            ['form' => $form->createView()
            ]);
    }

    /**
     * 
     * @Route("/stagiaire/infraction", name="stagiaire_infraction_index")
     */
    
    public function infractionIndex(StagiaireRepository $repo, PaginatorInterface $paginator, InfractionRepository $iRepo, NatureInfractionrepository $natRepo, Request $request) :Response
    {
       
            $infraction = $iRepo->findAll();
            $natureInfraction = $natRepo->findAll();
            $s = $request->query->get('q');
            $allstagiaires = $repo->findAllWithSearch($s);
              
            $stagiaires = $paginator->paginate(
                $allstagiaires,
                $request->query->getInt('page', 1), /*page number*/
                5 /*limit per page*/
            );
        
            $stagiaires ->setCustomParameters([
                'position' => 'centered',
                'size' => 'small',
                'rounded' => true,
            ]);
           
            return $this->render('stagiaire/infraction.html.twig', [
                'stagiaires' => $stagiaires,
                'infraction' => $infraction,
                'natureInfraction' => $natureInfraction
               
            ]);
        }

    /**
     *  @Route("/stagiaire/infraction/ajouter", name="infraction_ajouter")
     *  @Route("/stagiaire/infraction/{id}/modifier", name="infraction_modifier")
     */
    public function infractionForm(Infraction $infraction = null, InfractionRepository $repoInfraction, Request $request, ObjectManager $manager)
    {
            if(!$infraction){
            $infraction = new infraction();
            }
            $form = $this->createForm(InfractionType::class, $infraction);
            $form->handleRequest($request);
            
            if($form->isSubmitted() && $form->isValid()){

                $lieuInfraction = $infraction->getLieuInfraction();
                $dateInfraction = $infraction->getDateInfraction();
                $natureInfraction = $infraction->getNatureInfraction();
                $dateCondamnation = $infraction->getDateCondamnation();
                $numeroParquet = $infraction->getNumeroParquet();
                $tribunal = $infraction->getTribunal();

                $nbrs = $repoInfraction->counter($lieuInfraction, $dateInfraction, $natureInfraction, $dateCondamnation, $numeroParquet, $tribunal);
                $nbr = $nbrs[0][1];
         
                if($infraction->getId() === null && $nbr === "0"){
                    $manager->persist($infraction);
                    $manager->flush();
                }else if($infraction->getId() !== null){
                    $manager->persist($infraction);
                    $manager->flush();
                }else{
                    return $this->render('stagiaire/infraction/modifier.html.twig', [
                        
                        'formInfraction' => $form->createView(),
                        'edit' => $infraction->getId() !== null,
                        'infraction' => $infraction,
                        'error' => 'error'
                    ]);
                }
                return $this->redirectToRoute('stagiaire_infraction_index');
            }
            return $this->render('stagiaire/infraction/modifier.html.twig', [
                'formInfraction' => $form->createView(),
                'edit' => $infraction->getId() !== null,
                'infraction' => $infraction,
                'error' => 'error'
                ]);
            }

    /**
     * PDF Liste des stagiaires
     * @Route("/stagiaire/imprimer", name="stagiaire_imprimer", methods={"GET"})
     */
    public function print(StagiaireRepository $repo)
    {
       
    // Configure Dompdf according to your needs
    $pdfOptions = new Options();
    $pdfOptions->set('defaultFont', 'Arial');
    
    // Instantiate Dompdf with our options
    $dompdf = new Dompdf($pdfOptions);
    $stagiaires = $repo->findAll();
    // Retrieve the HTML generated in our twig file
    $html = $this->renderView('stagiaire/pdf.html.twig', [
        'stagiaires' => $stagiaires
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
    $canvas->page_text(50, 574, "Liste des stagiaires au $date", null, 10, array(0, 0, 0));
    // Output the generated PDF to Browser (force download)
    $dompdf->stream("liste_stagiaires.pdf", [
        "Attachment" => false
    ]);
}

/**
     * PDF détails stagiaires
     * @Route("/stagiaire/{id}/imprimer", name="stagiaire_afficher_imprimer")
     */
    public function imprimerShowOne(stagiaire $stagiaire, Request $request)
    {
        $pdfOptions = new Options();
    $pdfOptions->set('defaultFont', 'Arial');
    
    // Instantiate Dompdf with our options
    $dompdf = new Dompdf($pdfOptions);
   $stagiaire ->getId();
  
    // Retrieve the HTML generated in our twig file
    $html = $this->renderView('stagiaire/pdf_show.html.twig', [
        'stagiaire' => $stagiaire
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
    $canvas->page_text(50, 574, "Détails - {$stagiaire} au $date", null, 10, array(0, 0, 0));
    // Output the generated PDF to Browser (force download)
    $dompdf->stream("details_{$stagiaire}.pdf", [
        "Attachment" => false
    ]);
}

    /**
    * PDF facture stagiaire
     * @Route("/stagiaire/{id}/facture", name="stagiaire_facture")
     */
    public function facture(stagiaire $stagiaire, Request $request, ObjectManager $manager)
    {
    $pdfOptions = new Options();
    $pdfOptions->set('defaultFont', 'Arial');
    
    // Instantiate Dompdf with our options
    $dompdf = new Dompdf($pdfOptions);
   $stagiaire ->getId();
//    dump($stagiaire);
//    die();
   //Ajout de la date de la facture
   foreach($stagiaire ->getParticipations() as $p) 
    { 
        if (is_null($p->getDateFacture())) { 
            $p->setDateFacture((new \DateTime()));
    
            $manager->persist($p);
            $manager->flush();
        }        
   }
   
    // Retrieve the HTML generated in our twig file
    $html = $this->renderView('stagiaire/pdf_facture.html.twig', [
        'stagiaire' => $stagiaire,
        
    ]);
    
    // Load HTML to Dompdf
    $dompdf->loadHtml($html);
    
    // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
    $dompdf->setPaper('A4', 'portrait');

    // Render the HTML as PDF
    $dompdf->render();
    $canvas = $dompdf->get_canvas();
    $date = date("d-m-Y");
    // $canvas->page_text(450, 80, "Besançon, le $date", null, 10, array(0, 0, 0));
    $canvas->page_text(120, 780, "Association Franc-comtoise d’Education Routière – 7 Square Saint Amour 25000 Besançon", null, 10, array(.4, .4, .8));
    $canvas->page_text(200, 790, "Tél : 06 24 18 32 41 – Courriel : afer.wnr@gmail.com", null, 10, array(.4, .4, .8));
    $canvas->page_text(240, 800, "N° de SIRET : 820 306 165 00011", null, 10, array(.4, .4, .8));
    $canvas->page_text(210, 810, "N° de Formation Professionnelle : 27 25 03054 25", null, 10, array(.4, .4, .8));
    // Output the generated PDF to Browser (force download)
    $dompdf->stream("facture_{$stagiaire}.pdf", [
        "Attachment" => false
    ]);
}

    /**
    * PDF inscription stagiaire
     * @Route("/stagiaire/{id}/inscription", name="stagiaire_inscription")
     */
    public function inscription(stagiaire $stagiaire, Request $request, ObjectManager $manager)
    {
    $pdfOptions = new Options();
    $pdfOptions->set('defaultFont', 'Arial');
    
    // Instantiate Dompdf with our options
    $dompdf = new Dompdf($pdfOptions);
    $stagiaire ->getId();
   //Ajout de la date de la facture
   foreach($stagiaire ->getParticipations() as $p) 
    { 
        if (is_null($p->getDateInscription())) { 
            $p->setDateInscription((new \DateTime()));
    
            $manager->persist($p);
            $manager->flush();
        }        
   }
   
    // Retrieve the HTML generated in our twig file
    $html = $this->renderView('stagiaire/pdf_inscription.html.twig', [
        'stagiaire' => $stagiaire,
        
    ]);
    
    // Load HTML to Dompdf
    $dompdf->loadHtml($html);
    
    // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
    $dompdf->setPaper('A4', 'portrait');

    // Render the HTML as PDF
    $dompdf->render();
    $canvas = $dompdf->get_canvas();
    
    $canvas->page_text(120, 780, "Association Franc-comtoise d’Education Routière – 7 Square Saint Amour 25000 Besançon", null, 10, array(.4, .4, .8));
    $canvas->page_text(200, 790, "Tél : 06 24 18 32 41 – Courriel : afer.wnr@gmail.com", null, 10, array(.4, .4, .8));
    $canvas->page_text(240, 800, "N° de SIRET : 820 306 165 00011", null, 10, array(.4, .4, .8));
    $canvas->page_text(210, 810, "N° de Formation Professionnelle : 27 25 03054 25", null, 10, array(.4, .4, .8));
    // Output the generated PDF to Browser (force download)
    $dompdf->stream("inscription_{$stagiaire}.pdf", [
        "Attachment" => false
    ]);
}

/**
    * PDF convocation stagiaire
     * @Route("/stagiaire/{id}/convocation", name="stagiaire_convocation")
     */
    public function convocation(stagiaire $stagiaire, Request $request, ObjectManager $manager)
    {
    $pdfOptions = new Options();
    $pdfOptions->set('defaultFont', 'Arial');
    $pdfOptions->set('isRemoteEnabled', TRUE);
    $pdfOptions->set('isHtml5ParserEnabled', TRUE);
    // Instantiate Dompdf with our options
    $dompdf = new Dompdf($pdfOptions);
    $stagiaire ->getId();
   //Ajout de la date de la facture
   foreach($stagiaire ->getParticipations() as $p) 
    { 
        if (is_null($p->getDateConvocation())) { 
            $p->setDateConvocation((new \DateTime()));
    
            $manager->persist($p);
            $manager->flush();
        }  
        
   }
   
    // Retrieve the HTML generated in our twig file
    $html = $this->renderView('stagiaire/pdf_convocation.html.twig', [
        'stagiaire' => $stagiaire,
        
    ]);
    
    // Load HTML to Dompdf
    $dompdf->loadHtml($html);
    
    // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
    $dompdf->setPaper('A4', 'portrait');

    // Render the HTML as PDF
    $dompdf->render();
    $canvas = $dompdf->get_canvas();
    
    $canvas->page_text(120, 780, "Association Franc-comtoise d’Education Routière – 7 Square Saint Amour 25000 Besançon", null, 10, array(.4, .4, .8));
    $canvas->page_text(200, 790, "Tél : 06 24 18 32 41 – Courriel : afer.wnr@gmail.com", null, 10, array(.4, .4, .8));
    $canvas->page_text(240, 800, "N° de SIRET : 820 306 165 00011", null, 10, array(.4, .4, .8));
    $canvas->page_text(210, 810, "N° de Formation Professionnelle : 27 25 03054 25", null, 10, array(.4, .4, .8));
    // Output the generated PDF to Browser (force download)
    $dompdf->stream("convocation_{$stagiaire}.pdf", [
        "Attachment" => false
    ]);
}

    }

   