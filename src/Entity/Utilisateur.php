<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * @ORM\Entity(repositoryClass="App\Repository\UtilisateurRepository")
 */
class Utilisateur 
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $identifiant;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomUtilisateur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenomUtilisateur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mdpUtilisateur;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Role", inversedBy="utilisateurs")
     */
    private $role;

    public
    function getId(): ? int {
        return $this->id;
    }

    public
    function getIdentifiant() : ? string {
        return $this->identifiant;
    }

    public
    function setIdentifiant(string $identifiant) : self {
        $this->identifiant = $identifiant;

        return $this;
    }

    public
    function getNomUtilisateur(): ? string {
        return $this->nomUtilisateur;
    }

    public
    function setNomUtilisateur(string $nomUtilisateur) : self {
        $this->nomUtilisateur = $nomUtilisateur;
        return $this;
    }

    public
    function getPrenomUtilisateur(): ? string {
        return $this->prenomUtilisateur;
    }

    public
    function setPrenomUtilisateur(string $prenomUtilisateur) : self {
        $this->prenomUtilisateur = $prenomUtilisateur;

        return $this;
    }

    public
    function getMdpUtilisateur(): ? string {
        return $this->mdpUtilisateur;
    }

    public
    function setMdpUtilisateur(string $mdpUtilisateur) : self {
        $this->mdpUtilisateur = $mdpUtilisateur;

        return $this;
    }

    public
    function getRole(): ? Role {
        return $this->role;
    }

    public
    function setRole( ? Role $role) : self {
        $this->role = $role;

        return $this;
    }
    /**
     * @return (roll|string)[] The user roles
     */
    public  function getRoles() {
        // $roles = $this->roles;
        // // guarantees that a user always has at least one role for security
        // if (empty($roles)) {
        //     $roles[] = 'ADMIN';
        // }
      
    }
 

}