<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ParticipationRepository")
 */
class Participation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $facture;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Stagiaire", inversedBy="participations")
     */
    private $stagiaire;

     /**
     * @ORM\OneToMany(targetEntity="App\Entity\Stagiaire", mappedBy="stage", cascade={"persist"})
     */
    //private $stagiaires;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Stage", inversedBy="participations")
     */
    private $stage;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Stage", mappedBy="stagiaire", cascade={"persist"})
     */
    //private $stages;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $datefacture;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateInscription;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateConvocation;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateAttestation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cas", inversedBy="participations")
     */
    private $cas;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Cas", mappedBy="stagiaire", cascade={"persist"})
     */
    //private $cass;

    public function __construct()
    {
       
        $this->createdAt = new \DateTime();
    }

    public function getFacture(): ?int
    {
        return $this->facture;
    }

    public function getStagiaire(): ?Stagiaire
    {
        return $this->stagiaire;
    }

    public function setStagiaire(?Stagiaire $stagiaire): self
    {
        $this->stagiaire = $stagiaire;

        return $this;
    }

    public function getStagiaires()
    {
        return $this->stagiaires;
    }

    public function setStagiaires($stagiaires)
    {
        $this->stagiaires = $stagiaires;

        return $this;
    }

    public function getStage(): ?Stage
    {
        return $this->stage;
    }

    public function setStage(?Stage $stage): self
    {
        $this->stage = $stage;

        return $this;
    }

    public function getStages()
    {
        return $this->stages;
    }

    public function setStages($stages)
    {
        $this->stages = $stages;

        return $this;
    }
/**
    *@return \Datetime
    */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }


    public function getDatefacture(): ?\DateTimeInterface
    {
        return $this->datefacture;
    }

    public function setDatefacture(?\DateTimeInterface $datefacture): self
    {
        $this->datefacture = $datefacture;

        return $this;
    }

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->dateInscription;
    }

    public function setDateInscription(?\DateTimeInterface $dateInscription): self
    {
        $this->dateInscription = $dateInscription;

        return $this;
    }

    public function getDateConvocation(): ?\DateTimeInterface
    {
        return $this->dateConvocation;
    }

    public function setDateConvocation(?\DateTimeInterface $dateConvocation): self
    {
        $this->dateConvocation = $dateConvocation;

        return $this;
    }

    public function getDateAttestation(): ?\DateTimeInterface
    {
        return $this->dateAttestation;
    }

    public function setDateAttestation(?\DateTimeInterface $dateAttestation): self
    {
        $this->dateAttestation = $dateAttestation;

        return $this;
    }

    public function getCas(): ?Cas
    {
        return $this->cas;
    }

    public function setCas(?Cas $cas): self
    {
        $this->cas = $cas;

        return $this;
    }
    
    public function getCass()
    {
        return $this->cass;
    }

    public function setCass($cass)
    {
        $this->cass = $cass;

        return $this;
    }

}
