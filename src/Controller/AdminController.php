<?php

namespace App\Controller;

use Twig\Environment;
use App\Repository\StageRepository;
use App\Repository\StagiaireRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{

    /**
     * @Route("/", name="admin")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig');
    }

    /**
    * @Route("/countCivilite", name="count_civilite")
    */
    public function countCivilite(StagiaireRepository $repoStagiaire, Request $request, ObjectManager $manager)
    {

        if($request->isMethod('POST')){
            $homme = 11;
            $femme = 12;
            $nbrHomme = $repoStagiaire->counterCivilite($homme);
            $nbrFemme = $repoStagiaire->counterCivilite($femme);
            


            return new JsonResponse(["nbHomme" => $nbrHomme , "nbFemme" => $nbrFemme]);

            
        } else {
            $response = new Response();
            $response = JsonResponse::fromJsonString('{"error":"exception"}');
        }
        
    }

    /**
    * @Route("/countStage", name="count_stage")
    */
    public function countStage(StageRepository $repoStage, Request $request, ObjectManager $manager)
    {

        if($request->isMethod('POST')){
            
            $month = [1,2,3,4,5,6,7,8,9,10,11,12];
            $year = date("Y");

            $nbrJanvier = $repoStage->counterStage($month[0], $year);
            $nbrFevrier = $repoStage->counterStage($month[1], $year);
            $nbrMars = $repoStage->counterStage($month[2], $year);
            $nbrAvril = $repoStage->counterStage($month[3], $year);
            $nbrMai = $repoStage->counterStage($month[4], $year);
            $nbrJuin = $repoStage->counterStage($month[5], $year);
            $nbrJuillet = $repoStage->counterStage($month[6], $year);
            $nbrAout = $repoStage->counterStage($month[7], $year);
            $nbrSeptembre = $repoStage->counterStage($month[8], $year);
            $nbrOctobre = $repoStage->counterStage($month[9], $year);
            $nbrNovembre = $repoStage->counterStage($month[10], $year);
            $nbrDecembre = $repoStage->counterStage($month[11], $year);
            
            return new JsonResponse(["janvier" => $nbrJanvier, "fevrier" => $nbrFevrier, "mars" => $nbrMars, "avril" => $nbrAvril, "mai" => $nbrMai, "juin" => $nbrJuin, "juillet" => $nbrJuillet, "aout" => $nbrAout, "septembre" => $nbrSeptembre, "octobre" => $nbrOctobre, "novembre" => $nbrNovembre, "decembre" => $nbrDecembre]);
            
        } else {
            $response = new Response();
            $response = JsonResponse::fromJsonString('{"error":"exception"}');
        }
        
    }

    /**
    * @Route("/countTitulaire", name="count_titulaire")
    */
    public function countTitulaire(StagiaireRepository $repoStagiaire, Request $request, ObjectManager $manager)
    {

        if($request->isMethod('POST')){

            $carteJeune = true;
            $partenaire = true;
            $adherent = true;

            $nbrTitulaire = $repoStagiaire->countTitulaire($carteJeune, $partenaire, $adherent);
            
            return new JsonResponse(["titulaire" => $nbrTitulaire]);
            
        } else {
            $response = new Response();
            $response = JsonResponse::fromJsonString('{"error":"exception"}');
        }
        
    }
}

