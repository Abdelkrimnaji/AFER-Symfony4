<?php

namespace App\Controller;

use App\Entity\LieuStage;
use App\Form\LieuStageType;
use App\Repository\LieuStageRepository;
use App\Repository\CommuneRepository;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Dompdf\Dompdf;
use Dompdf\Options;
/**
 * @Route("/admin")
 * @IsGranted("ROLE_ADMIN")
 */
class LieuStageController extends AbstractController { 

    /**
     * @Route("/stage/lieuStage", name="lieuStage_index")
     */
    public function index(LieuStageRepository $repo)
    {
        $lieuStages = $repo->findAll();

        return $this->render('lieuStage/index.html.twig', [
            'controller_name' => 'lieuStageController',
            'lieuStages' => $lieuStages
        ]);
    }
    /**
     *  @Route("/stage/lieuStage/ajouter", name="lieuStage_ajouter")
     *  @Route("/stage/lieuStage/{id}/modifier", name="lieuStage_modifier")
     */
    public function lieuStageForm(LieuStage $lieuStage = null, Request $request, ObjectManager $manager)
    {
        if(!$lieuStage){
        $lieuStage = new lieuStage();
        }
        $form = $this->createForm(lieuStageType::class, $lieuStage);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            // dump($request);
            // die();
            $manager->persist($lieuStage);
            $manager->flush();
            return $this->redirectToRoute('lieuStage_index');
        }
        return $this->render('lieuStage/ajouter.html.twig', [
            'formLieuStage' => $form->createView(),
            'editMode' => $lieuStage->getId() !== null
        ]);
    }
    /**
     *  @Route("/stage/lieuStage/{id}/supprimer", name="lieuStage_supprimer")
     */
    public function delete(LieuStage $lieuStage, ObjectManager $manager)
    {
        $manager->remove($lieuStage);
        $manager->flush();
        return $this->redirectToRoute('lieuStage_index');
    }
    /**
     * @Route("/stage/lieuStage/{id}/afficher", name="lieuStage_afficher")
     */
    public function showOne(LieuStage $lieuStage)
    {
        return $this->render('lieuStage/afficher.html.twig', [
            'lieuStage' => $lieuStage
        ]);
    }

    /**
     * @Route("/stage/lieucommune", name="stage_lieucommune")
     */
    public function lieuCommune(CommuneRepository $crepo, Request $request)
    {
        $commune = $request->request->get("lieu_stage_nom_commune");
        $communes= $crepo->findCommunes($commune);
      
        $response = new JsonResponse($communes); 
        // dump($response);
        // die;
        return $response;
    }       
    
    /**
     * @Route("/stage/lieuStage/imprimer", name="lieuStage_imprimer", methods={"GET"})
     */
    public function print(LieuStageRepository $repo)
    {
       
    // Configure Dompdf according to your needs
    $pdfOptions = new Options();
    $pdfOptions->set('defaultFont', 'Arial');
    
    // Instantiate Dompdf with our options
    $dompdf = new Dompdf($pdfOptions);
    $lieuStages = $repo->findAll();
    // Retrieve the HTML generated in our twig file
    $html = $this->renderView('lieuStage/pdf.html.twig', [
        'lieuStages' => $lieuStages
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
    $canvas->page_text(50, 574, "Liste des lieux de stage au $date", null, 10, array(0, 0, 0));
    // Output the generated PDF to Browser (force download)
    $dompdf->stream("liste_lieux_stage.pdf", [
        "Attachment" => false
    ]);
}
   
    }

