<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Repository\UserRepository;

use App\Form\ModificationUtilisateurType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/admin")
 * @IsGranted("ROLE_ADMIN")
 */
class UtilisateurController extends AbstractController
{
    /**
     * controlleur pour créer et gérer les utilisateurs
     * @Route("/utilisateur", name="utilisateur_index")
     */
    public function index(UserRepository $repoUser)
    {
        $users = $repoUser->findAll();

        return $this->render('utilisateur/index.html.twig', [
            'controller_name' => 'UtilisateurController',
            'users' => $users
        ]);
    }

    /**
     * @Route("/utilisateur/ajouter", name="utilisateur_ajouter")
     * @IsGranted("ROLE_ADMIN")
     */
    public function formAjouter(User $users = null, Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder) {

        $users = new User();
        
        $form = $this->createForm(RegistrationType::class, $users);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $hash = $encoder->encodePassword($users, $users->getPassword());

            $users->setPassword($hash);

            $users->setRoles([$form->get('roles')->getData()]);

            $manager->persist($users);
            $manager->flush();

            return $this->redirectToRoute('utilisateur_index');
        }

        return $this->render('utilisateur/ajouter.html.twig', [
            'formRegistration' => $form->createView(),
            'editMode' => $users->getId() !== null
        ]);
    }

    /**
     * @Route("/utilisateur/{id}/modifier", name="utilisateur_modifier")
     * @IsGranted("ROLE_ADMIN")
     */
    public function formModifier(User $users = null, Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder) {

        if(!$users) {
            $users = new User();
        }

        $form = $this->createForm(ModificationUtilisateurType::class, $users);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $users->setRoles([$form->get('roles')->getData()]);

            $manager->persist($users);
            $manager->flush();

            return $this->redirectToRoute('utilisateur_index');
        }

        return $this->render('utilisateur/modifier.html.twig', [
            'formModificationUtilisateur' => $form->createView(),
            'editMode' => $users->getId() !== null
        ]);
    }

    /**
     * @Route("/utilisateur/{id}", name="utilisateur_afficher")
     */
    public function showOne(User $users)
    {
        return $this->render('utilisateur/afficher.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @Route("/utilisateur/{id}/supprimer", name="utilisateur_supprimer")
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(User $users, Request $request, ObjectManager $manager) {

        $manager->remove($users);
        $manager->flush();

        return $this->redirectToRoute('utilisateur_index');
    }

}