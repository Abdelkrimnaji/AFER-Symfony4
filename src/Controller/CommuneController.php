<?php

namespace App\Controller;

use App\Entity\Commune;
use App\Form\CommuneType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ObjectManager;
use App\Repository\CommuneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class CommuneController extends AbstractController
{
/**
 * @Route("/search-commune", name="search-commune", methods="GET")
 *  
*@param Request $request
*@return JsonResponse
 */

    // public function listCommune(Request $request)
    // {
    //     $em = $this->getDoctrine()->getManager();
    //     $communeRepository = $em->getRepository(Commune::class);
        
    //     $communes = $communeRepository->createQueryBuilder("q")
    //         ->where("q.commune = :communeid")
    //         ->setParameter("communeid", $request->query->get("communeid"))
    //         ->getQuery()
    //         ->getResult();
        

    //     $responseArray = array();
    //     foreach($communes as $commune){
    //         $responseArray[] = array(
    //             "id" => $commune->getId(),
    //             // "cp" => $cp->getName()
    //         );
    //     }
        
       
    //     return new JsonResponse($responseArray);

     
    // }
}