<?php

namespace App\Controller;

use App\Entity\Prefecture;
use App\Form\PrefectureType;
use App\Entity\PrefectureService;
use App\Entity\PrefectureAutorite;

use App\Form\PrefectureServiceType;
use App\Form\PrefectureAutoriteType;

use App\Repository\CommuneRepository;
use App\Repository\PrefectureRepository;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\PrefectureServiceRepository;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PrefectureAutoriteRepository;

use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin")
 * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_PREFECTURE')")
 */
class PrefectureController extends AbstractController
{
    /**
     * @Route("/prefecture", name="prefecture_index")
     */
    public function index(PrefectureRepository $repoPrefecture)
    {
        $prefectures = $repoPrefecture->findAll();

        return $this->render('prefecture/prefecture.html.twig', [
            'controller_name' => 'PrefectureController',
            'prefectures' => $prefectures
        ]);
    }

    /**
    * @Route("/prefecture/commune", name="prefecture_commune")
    */
    public function PrefectureCommune(CommuneRepository $crepo, Request $request)
    {
        $commune = $request->request->get("prefecture_communePrefecture");
        $communes= $crepo->findCommunes($commune);
  
        $response = new JsonResponse($communes); 

        return $response;
    }

    /**
     * @Route("/prefecture/service", name="prefectureService_index")
     */
    public function indexService(PrefectureServiceRepository $repoPrefectureService)
    {
        $services = $repoPrefectureService->findAll();

        return $this->render('prefecture/service.html.twig', [
            'services' => $services
        ]);
    }

    /**
     * @Route("/prefecture/autorite", name="prefectureAutorite_index")
     */
    public function indexAutorite(PrefectureAutoriteRepository $repoPrefectureAutorite)
    {
        $autorites = $repoPrefectureAutorite->findAll();

        return $this->render('prefecture/autorite.html.twig', [
            'autorites' => $autorites
        ]);
    }

    /**
     * @Route("/prefecture/ajouter", name="prefecture_ajouter")
     * @Route("/prefecture/{id}/modifier", name="prefecture_modifier")
     * @IsGranted("ROLE_ADMIN")
     */
    public function form(Prefecture $prefectures = null,PrefectureRepository $repoPrefecture, Request $request, ObjectManager $manager) {

        if(!$prefectures) {
            $prefectures = new Prefecture();
        }

        $form = $this->createForm(PrefectureType::class, $prefectures);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $prefectureNom = $prefectures->getNomPrefecture();
            $prefectureCommune = $prefectures->getCommunePrefecture();
            $nbrs = $repoPrefecture->counter($prefectureNom,$prefectureCommune);
            $nbr = $nbrs[0][1];
      
            if($nbr === "0" && $prefectures->getId() === null){
                $manager->persist($prefectures);
                $manager->flush();
            }else if($prefectures->getId() !== null){
                $manager->persist($prefectures);
                $manager->flush();
            }else{
                return $this->render('prefecture/ajouterPrefecture.html.twig', [
                    'formPrefecture' => $form->createView(),
                    'editMode' => $prefectures->getId() !== null,
                    'error' => 'error'
                ]);
            }
            return $this->redirectToRoute('prefecture_index');
        }

        return $this->render('prefecture/ajouterPrefecture.html.twig', [
            'formPrefecture' => $form->createView(),
            'editMode' => $prefectures->getId() !== null
        ]);
    }


    /**
     * @Route("/prefecture/{id}", name="prefecture_afficher")
     */
    public function showOne(Prefecture $prefectures)
    {
        return $this->render('prefecture/afficherPrefecture.html.twig', [
            'prefectures' => $prefectures
        ]);
    }

    /**
     * @Route("/prefecture/{id}/supprimer", name="prefecture_supprimer")
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Prefecture $prefectures, Request $request, ObjectManager $manager) {

        $manager->remove($prefectures);
        $manager->flush();

        return $this->redirectToRoute('prefecture_index');
    }

    /**
     * @Route("/prefecture/service/ajouter", name="prefectureService_ajouter")
     * @Route("/prefecture/service/{id}/modifier", name="prefectureService_modifier")
     * @IsGranted("ROLE_ADMIN")
     */
    public function ajoutPrefectureService(PrefectureService $service = null, Request $request, ObjectManager $manager) {

        if(!$service) {
            $service = new PrefectureService();
        }

        $form = $this->createForm(PrefectureServiceType::class, $service);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($service);
            $manager->flush();

            return $this->redirectToRoute('prefectureService_index');
        }

        return $this->render('prefecture/ajouterService.html.twig', [
            'formPrefectureService' => $form->createView(),
            'editMode' => $service->getId() !== null
        ]);
    }

    /**
     * @Route("/prefecture/service/{id}/supprimer", name="prefectureService_supprimer")
     * @IsGranted("ROLE_ADMIN")
     */
    public function deletePrefectureService(PrefectureService $service, Request $request, ObjectManager $manager) {

        $manager->remove($service);
        $manager->flush();

        return $this->redirectToRoute('prefectureService_index');
    }

    /**
     * @Route("/prefecture/autorite/ajouter", name="prefectureAutorite_ajouter")
     * @Route("/prefecture/autorite/{id}/modifier", name="prefectureAutorite_modifier")
     * @IsGranted("ROLE_ADMIN")
     */
    public function ajoutPrefectureAutorite(PrefectureAutorite $autorite = null, Request $request, ObjectManager $manager) {

        if(!$autorite) {
            $autorite = new PrefectureAutorite();
        }

        $form = $this->createForm(PrefectureAutoriteType::class, $autorite);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($autorite);
            $manager->flush();

            return $this->redirectToRoute('prefectureAutorite_index');
        }

        return $this->render('prefecture/ajouterAutorite.html.twig', [
            'formPrefectureAutorite' => $form->createView(),
            'editMode' => $autorite->getId() !== null
        ]);
    }

    /**
     * @Route("/prefecture/autorite/{id}/supprimer", name="prefectureAutorite_supprimer")
     * @IsGranted("ROLE_ADMIN")
     */
    public function deletePrefectureAutorite(PrefectureAutorite $autorite, Request $request, ObjectManager $manager) {

        $manager->remove($autorite);
        $manager->flush();

        return $this->redirectToRoute('prefectureAutorite_index');
    }

    /**
    * @Route("/prefecture/service/loadFormServicePrefecture", name="prefecture_service_pop")
    * @IsGranted("ROLE_ADMIN")
    */
    public function popService(PrefectureService $service = null, Request $request,PrefectureServiceRepository $repoService, ObjectManager $manager)
    {
        if(!$service){
            $service = new PrefectureService();
        }
         $formService = $this->createForm( PrefectureServiceType::class, $service, array('method'=>'POST') );
        
        $formService->handleRequest( $request );
      
        if($request->isMethod('POST')){
            $prefectureService = $request->request->get('prefecture_service_nom');

            $nbrs = $repoService->counter($prefectureService);
            $nbr = $nbrs[0][1];
    
            if(strlen($prefectureService) > 0 && $nbr === "0"){
                 $service->setNom($prefectureService);
                $manager->persist( $service );
                $manager->flush();
                $response = new Response();
                $response = JsonResponse::fromJsonString('{"id":'.$service->getId().', "value":"'.$service->getNom().'"}');
            }else{
                $response = new Response();
                $response = JsonResponse::fromJsonString('{"error":"existe"}');
            }
             return $response;
        }
        
        return $this->render('prefecture/popService.html.twig', 
            ['form' => $formService->createView()
            ]);
    }

    /**
    * @Route("/prefecture/autorite/loadFormAutoritePrefecture", name="prefecture_autorite_pop")
    * @IsGranted("ROLE_ADMIN")
    */
    public function popAutorite(PrefectureAutorite $autorite = null,PrefectureAutoriteRepository $repoAutorite, Request $request, ObjectManager $manager)
    {
        if(!$autorite){
            $autorite = new PrefectureAutorite();
        }
        $formAutorite = $this->createForm( PrefectureAutoriteType::class, $autorite, array('method'=>'POST') );
        
        $formAutorite->handleRequest( $request );
      
        if($request->isMethod('POST')){
            $prefectureAutorite = $request->request->get('prefecture_autorite_nom');

            $nbrs = $repoAutorite->counter($prefectureAutorite);
            $nbr = $nbrs[0][1];

            if(strlen($prefectureAutorite) > 0 && $nbr === "0"){
                $autorite->setNom($prefectureAutorite);
                $manager->persist( $autorite );
                $manager->flush();
                $response = new Response();
                $response = JsonResponse::fromJsonString('{"id":'.$autorite->getId().', "value":"'.$autorite->getNom().'"}');
            }else{
                $response = new Response();
                $response = JsonResponse::fromJsonString('{"error":"existe"}');
            }
             return $response;
        }
        
        return $this->render('prefecture/popAutorite.html.twig', 
            ['form' => $formAutorite->createView()
            ]);
    }

    /**
    * @Route("/prefecture/autorite/supprAlertFormAutoritePrefecture", name="prefecture_autorite_suppr_alert")
    * @IsGranted("ROLE_ADMIN")
    */
    public function supprAutorite(PrefectureRepository $repoPrefecture, Request $request, ObjectManager $manager)
    {

        if($request->isMethod('POST')){

            $id = $request->request->get('id');
            
            if($id > 0){
                $nbrs = $repoPrefecture->counterAutorite($id);
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
    * @Route("/prefecture/service/supprAlertFormServicePrefecture", name="prefecture_service_suppr_alert")
    * @IsGranted("ROLE_ADMIN")
    */
    public function supprService(PrefectureRepository $repoPrefecture, Request $request, ObjectManager $manager)
    {

        if($request->isMethod('POST')){

            $id = $request->request->get('id');
            
            if($id > 0){
                $nbrs = $repoPrefecture->counterService($id);
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
     * @Route("/prefecture/imprimer", name="prefecture_imprimer", methods={"GET"})
     */
    public function print(PrefectureRepository $repo)
    {
       
    // Configure Dompdf according to your needs
    $pdfOptions = new Options();
    $pdfOptions->set('defaultFont', 'Arial');
    
    // Instantiate Dompdf with our options
    $dompdf = new Dompdf($pdfOptions);
    $prefectures = $repo->findAll();
    // Retrieve the HTML generated in our twig file
    $html = $this->renderView('prefecture/pdf.html.twig', [
        'prefectures' => $prefectures
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
    $canvas->page_text(50, 574, "Liste des prefectures au $date", null, 10, array(0, 0, 0));
    // Output the generated PDF to Browser (force download)
    $dompdf->stream("liste_prefectures.pdf", [
        "Attachment" => false
    ]);
}
}
