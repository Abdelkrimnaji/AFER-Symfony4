<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CasRepository")
 */
class Cas
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
    private $numeroCas;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $intituleCas;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tarif", inversedBy="cas")
     */
    private $tarifs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Participation", mappedBy="cas", cascade={"persist"})
     */
    private $participations;


    public function __construct()
    {
        $this->participations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroCas(): ?string
    {
        return $this->numeroCas;
    }

    public function setNumeroCas(string $numeroCas): self
    {
        $this->numeroCas = $numeroCas;

        return $this;
    }

    public function getIntituleCas(): ?string
    {
        return $this->intituleCas;
    }

    public function setIntituleCas(string $intituleCas): self
    {
        $this->intituleCas = $intituleCas;

        return $this;
    }

    public function getTarifs(): ?Tarif
    {
        return $this->tarifs;
    }

    public function setTarifs(?Tarif $tarifs): self
    {
        $this->tarifs = $tarifs;

        return $this;
    }

    /**
     * @param mixed $participations
     */
    public function getParticipations()
    {
       
        return $this->participations;
    }

    public function setParticipations($participations)
    {
        
            $this->
            $participations->$participations;
        }
        
// On récupère participations pour les injecter dans notre champs "cas"
    // Permet de marquer les cas déjà sélectionnés dans la DB
    public function getStagiaire()
    {
        $stagiaires = new ArrayCollection();
        foreach($this->participations as $p)
        {
            $stagiaires[] = $p->getStagiaire();
        }
        return $stagiaires;
    }
    public function setStagiaire($stagiaires)
    { 
        $this->stagiaires = $stagiaires;

        return $this;
    }
    public function addParticipation($participations)
    {
        $this->participations[] = $participations;
    }
    public function removeParticipation($participations)
    {
        $this->participations->removeElement($participations);
    }

 
 /**
     * toString
     */
    public function __toString() {
        return $this->getNumeroCas();
    }

}
