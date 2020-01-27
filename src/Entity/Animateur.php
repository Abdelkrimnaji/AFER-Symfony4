<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AnimateurRepository")
 */
class Animateur
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez insérer un nom.")
     *
     */
    private $nomAnimateur;
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez insérer un prénom.")
     * 
     */
    private $prenomAnimateur;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(min = 2, max = 255, minMessage = "La valeur insérée doit être comprise entre 2 et 255 caractères", maxMessage = "La valeur insérée doit être comprise entre 2 et 255 caractères")
     */
    private $raisonSocialeAnimateur;
    /**
     * @ORM\Column(type="boolean")
     */
    private $gtaAnimateur = false;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $communeAnimateur;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $regionAnimateur;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $numeroRueAnimateur;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $rueAnimateur;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Regex(pattern = "/^[0-9-]/", match = true, message = "Vous avez inséré autre chose qu'un chiffre")
     * 
     */
    private $numeroPortableAnimateur;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Regex(pattern = "/^[0-9-]/", match = true, message = "Vous avez inséré autre chose qu'un chiffre")
     * 
     */
    private $numeroFixeAnimateur;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Email(message = "L'adresse email saisie n'est pas valide")
     */
    private $emailAnimateur;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(min = 2, max = 255, minMessage = "La valeur insérée doit être comprise entre 2 et 255 caractères", maxMessage = "La valeur insérée doit être comprise entre 2 et 255 caractères")
     */
    private $urssafAnimateur;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(min = 2, max = 255, minMessage = "La valeur insérée doit être comprise entre 2 et 255 caractères", maxMessage = "La valeur insérée doit être comprise entre 2 et 255 caractères")
     */
    private $siretAnimateur;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(min = 2, max = 255, minMessage = "La valeur insérée doit être comprise entre 2 et 255 caractères", maxMessage = "La valeur insérée doit être comprise entre 2 et 255 caractères")
     */
    private $observationsAnimateur;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\AnimateurStatut", inversedBy="relation")
     */
    private $animateurStatut;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\AnimateurFonction", inversedBy="relation")
     */
    private $animateurFonction;
     /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Stage", mappedBy="animateurs")
     */
    private $stages;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Civilite", inversedBy="animateurs")
     * @ORM\JoinColumn
     */
    private $civilite;



    public function __construct()
    {
        $this->stages = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getNomAnimateur(): ?string
    {
        return $this->nomAnimateur;
    }
    public function setNomAnimateur(string $nomAnimateur): self
    {
        $this->nomAnimateur = $nomAnimateur;
        return $this;
    }
    public function getPrenomAnimateur(): ?string
    {
        return $this->prenomAnimateur;
    }
    public function setPrenomAnimateur(string $prenomAnimateur): self
    {
        $this->prenomAnimateur = $prenomAnimateur;
        return $this;
    }
    public function getRaisonSocialeAnimateur(): ?string
    {
        return $this->raisonSocialeAnimateur;
    }
    public function setRaisonSocialeAnimateur(string $raisonSocialeAnimateur): self
    {
        $this->raisonSocialeAnimateur = $raisonSocialeAnimateur;
        return $this;
    }
    public function getGtaAnimateur(): ?bool
    {
        return $this->gtaAnimateur;
    }
    public function setGtaAnimateur(string $gtaAnimateur): self
    {
        $this->gtaAnimateur = $gtaAnimateur;
        return $this;
    }
    public function getCommuneAnimateur(): ?string
    {
        return $this->communeAnimateur;
    }
    public function setCommuneAnimateur(string $communeAnimateur): self
    {
        $this->communeAnimateur = $communeAnimateur;
        return $this;
    }
    public function getRegionAnimateur(): ?string
    {
        return $this->regionAnimateur;
    }
    public function setRegionAnimateur(string $regionAnimateur): self
    {
        $this->regionAnimateur = $regionAnimateur;
        return $this;
    }
    public function getNumeroRueAnimateur(): ?string
    {
        return $this->numeroRueAnimateur;
    }
    public function setNumeroRueAnimateur(string $numeroRueAnimateur): self
    {
        $this->numeroRueAnimateur = $numeroRueAnimateur;
        return $this;
    }
    public function getRueAnimateur(): ?string
    {
        return $this->rueAnimateur;
    }
    public function setRueAnimateur(string $rueAnimateur): self
    {
        $this->rueAnimateur = $rueAnimateur;
        return $this;
    }
    public function getNumeroPortableAnimateur(): ?string
    {
        return $this->numeroPortableAnimateur;
    }
    public function setNumeroPortableAnimateur(string $numeroPortableAnimateur): self
    {
        $this->numeroPortableAnimateur = $numeroPortableAnimateur;
        return $this;
    }
    public function getNumeroFixeAnimateur(): ?string
    {
        return $this->numeroFixeAnimateur;
    }
    public function setNumeroFixeAnimateur(string $numeroFixeAnimateur): self
    {
        $this->numeroFixeAnimateur = $numeroFixeAnimateur;
        return $this;
    }
    public function getEmailAnimateur(): ?string
    {
        return $this->emailAnimateur;
    }
    public function setEmailAnimateur(string $emailAnimateur): self
    {
        $this->emailAnimateur = $emailAnimateur;
        return $this;
    }
    public function getUrssafAnimateur(): ?string
    {
        return $this->urssafAnimateur;
    }
    public function setUrssafAnimateur(string $urssafAnimateur): self
    {
        $this->urssafAnimateur = $urssafAnimateur;
        return $this;
    }
    public function getSiretAnimateur(): ?string
    {
        return $this->siretAnimateur;
    }
    public function setSiretAnimateur(string $siretAnimateur): self
    {
        $this->siretAnimateur = $siretAnimateur;
        return $this;
    }
    public function getObservationsAnimateur(): ?string
    {
        return $this->observationsAnimateur;
    }
    public function setObservationsAnimateur(string $observationsAnimateur): self
    {
        $this->observationsAnimateur = $observationsAnimateur;
        return $this;
    }
    public function getAnimateurStatut(): ?AnimateurStatut
    {
        return $this->animateurStatut;
    }
    public function setAnimateurStatut(?AnimateurStatut $animateurStatut): self
    {
        $this->animateurStatut = $animateurStatut;
        return $this;
    }
    public function getAnimateurFonction(): ?AnimateurFonction
    {
        return $this->animateurFonction;
    }
    public function setAnimateurFonction(?AnimateurFonction $animateurFonction): self
    {
        $this->animateurFonction = $animateurFonction;
        return $this;
    }
     /**
    * @return Collection|Stage[]
    */
    public function getStages(): Collection
    {
        return $this->stages;
    }
    public function addStage(Stage $stage): self
    {
        if (!$this->stages->contains($stage)) {
            $this->stages[] = $stage;
            $stage->addStage($this);
        }
        return $this;
    }
    public function removeStage(Stage $stage): self
    {
        if ($this->stages->contains($stage)) {
            $this->stages->removeElement($stage);
            $stage->removeStage($this);
        }
        return $this;
    }

    public function getCivilite(): ?Civilite
    {
        return $this->civilite;
    }

    public function setCivilite(?Civilite $civilite): self
    {
        $this->civilite = $civilite;

        return $this;
    }
     
 /**
     * toString
     */
    public function __toString() {
        return $this->getPrenomAnimateur() . ' ' . $this->getNomAnimateur();
    }
}