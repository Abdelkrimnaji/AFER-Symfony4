<?php

namespace App\Controller;

use App\Entity\Infraction;
use App\Form\InfractionType;
use App\Repository\CommuneRepository;
use App\Repository\InfractionRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin")
 * @IsGranted("ROLE_ADMIN")
 */
class InfractionController extends AbstractController
{
    

    /**
     * @Route("/stagiaire/infraction/lieucommune", name="stagiaire_infraction_lieucommune")
     */
    public function lieuCommune(CommuneRepository $crepo, Request $request)
    {
        $commune = $request->request->get("infraction_lieuInfraction");
        $communes= $crepo->findCommunes($commune);
      
        $response = new JsonResponse($communes); 
        
        return $response;
    }       
}
