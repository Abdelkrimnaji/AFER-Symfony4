<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StagiaireRepository")
 */
class Stagiaire
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez insérer le nom du stagiaire.")
     * @Assert\Length(min = 2, max = 255, minMessage = "La valeur insérée doit être comprise entre 2 et 255 caractères", maxMessage = "La valeur insérée doit être comprise entre 2 et 255 caractères")
     * 
     */
    private $nomStagiaire;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez insérer le prénom du stagiaire.")
     * @Assert\Length(min = 2, max = 255, minMessage = "La valeur insérée doit être comprise entre 2 et 255 caractères", maxMessage = "La valeur insérée doit être comprise entre 2 et 255 caractères")
     * 
     */
    private $prenomStagiaire;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $communeStagiaire;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *  string|null
     * @Assert\Length(min = 2, max = 255, minMessage = "La valeur insérée doit être comprise entre 2 et 255 caractères", maxMessage = "La valeur insérée doit être comprise entre 2 et 255 caractères")
     * 
     */
    private $nomNaissanceStagiaire;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateNaissanceStagiaire;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min = 2, max = 255, minMessage = "La valeur insérée doit être comprise entre 2 et 255 caractères", maxMessage = "La valeur insérée doit être comprise entre 2 et 255 caractères")
     * @Assert\Regex(pattern = "/^[a-zA-Zàâçéèêëîïôûùüÿñæœ .-]*$/i", match = true, message = "{{ value }} contient un caractère non autorisé")
     */
    private $lieuNaissanceStagiaire;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min = 2, max = 255, minMessage = "La valeur insérée doit être comprise entre 2 et 255 caractères", maxMessage = "La valeur insérée doit être comprise entre 2 et 255 caractères")
     * 
     */
    private $adresseStagiaire;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min = 2, max = 255, minMessage = "La valeur insérée doit être comprise entre 2 et 255 caractères", maxMessage = "La valeur insérée doit être comprise entre 2 et 255 caractères")
     * @Assert\Regex(pattern = "/^[a-zA-Zàâçéèêëîïôûùüÿñæœ .-]*$/i", match = true, message = "{{ value }} contient un caractère non autorisé")
     */
    private $nationaliteStagiaire;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Regex(pattern = "/^[0-9-]/", match = true, message = "Vous avez inséré autre chose qu'un chiffre")
     */
    private $numeroPortableStagiaire;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Regex(pattern = "/^[0-9-]/", match = true, message = "Vous avez inséré autre chose qu'un chiffre")
     */
    private $numeroFixeStagiaire;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Email(message = "L'adresse email '{{ value }}' n'est pas valide")
     */
    private $emailStagiaire;

      /**
     * @ORM\Column(type="string", length=25)
     */
    private $numeroAdresseStagiaire;

  

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Civilite", inversedBy="stagiaires")
     * @ORM\JoinColumn(nullable=true)
     */
    private $civilite;
     
    // /**
    //  * @ORM\ManyToOne(targetEntity="App\Entity\Prefecture", inversedBy="stagiaires")
    //  * 
    //  */
    // private $prefecture;

    
    // /**
    //  * @ORM\ManyToOne(targetEntity="App\Entity\Tribunal", inversedBy="stagiaires")
    //  */
    // private $tribunal;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Licence", inversedBy="stagiaire")
     */
    private $licence;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Avantage", inversedBy="stagiaires")
     */
    private $avantage;

    
    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Infraction", inversedBy="stagiaire")
     */
    private $infraction;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Participation", mappedBy="stagiaire", cascade={"persist"})
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

    public function getNomStagiaire(): ?string
    {
        return $this->nomStagiaire;
    }

    public function setNomStagiaire(string $nomStagiaire): self
    {
        $this->nomStagiaire = $nomStagiaire;

        return $this;
    }

    public function getPrenomStagiaire(): ?string
    {
        return $this->prenomStagiaire;
    }

    public function setPrenomStagiaire(string $prenomStagiaire): self
    {
        $this->prenomStagiaire = $prenomStagiaire;

        return $this;
    }

    public function getCommuneStagiaire(): ?string
    {
        return $this->communeStagiaire;
    }

    public function setCommuneStagiaire(string $communeStagiaire): self
    {
        $this->communeStagiaire = $communeStagiaire;

        return $this;
    }

    public function getNomNaissanceStagiaire(): ?string
    {
        return $this->nomNaissanceStagiaire;
    }

    public function setNomNaissanceStagiaire(string $nomNaissanceStagiaire): self
    {
        $this->nomNaissanceStagiaire = $nomNaissanceStagiaire;

        return $this;
    }

    public function getDateNaissanceStagiaire(): ?DateTimeInterface
    {
        return $this->dateNaissanceStagiaire;
    }

    public function setDateNaissanceStagiaire(\DateTimeInterface $dateNaissanceStagiaire): self
    {
        $this->dateNaissanceStagiaire = $dateNaissanceStagiaire;

        return $this;
    }

    public function getLieuNaissanceStagiaire(): ?string
    {
        return $this->lieuNaissanceStagiaire;
    }

    public function setLieuNaissanceStagiaire(string $lieuNaissanceStagiaire): self
    {
        $this->lieuNaissanceStagiaire = $lieuNaissanceStagiaire;

        return $this;
    }

    public function getAdresseStagiaire(): ?string
    {
        return $this->adresseStagiaire;
    }

    public function setAdresseStagiaire(string $adresseStagiaire): self
    {
        $this->adresseStagiaire = $adresseStagiaire;

        return $this;
    }

    public function getNationaliteStagiaire(): ?string
    {
        return $this->nationaliteStagiaire;
    }

    public function setNationaliteStagiaire(string $nationaliteStagiaire): self
    {
        $this->nationaliteStagiaire = $nationaliteStagiaire;

        return $this;
    }

    public function getNumeroPortableStagiaire(): ?string
    {
        return $this->numeroPortableStagiaire;
    }

    public function setNumeroPortableStagiaire(string $numeroPortableStagiaire): self
    {
        $this->numeroPortableStagiaire = $numeroPortableStagiaire;

        return $this;
    }

    public function getNumeroFixeStagiaire(): ?string
    {
        return $this->numeroFixeStagiaire;
    }

    public function setNumeroFixeStagiaire(string $numeroFixeStagiaire): self
    {
        $this->numeroFixeStagiaire = $numeroFixeStagiaire;

        return $this;
    }

    public function getEmailStagiaire(): ?string
    {
        return $this->emailStagiaire;
    }

    public function setEmailStagiaire(string $emailStagiaire): self
    {
        $this->emailStagiaire = $emailStagiaire;

        return $this;
    }


    public function getNumeroAdresseStagiaire(): ?string
    {
        return $this->numeroAdresseStagiaire;
    }

    public function setNumeroAdresseStagiaire(string $numeroAdresseStagiaire): self
    {
        $this->numeroAdresseStagiaire = $numeroAdresseStagiaire;

        return $this;
    }

    

    public function getCivilite(): ?Civilite
    {
        return $this->civilite;
    }

    public function setCivilite(Civilite $civilite): self
    {
        $this->civilite = $civilite;

        return $this;
    }

    

    // public function getPrefecture(): ?Prefecture
    // {
    //     return $this->prefecture;
    // }

    // public function setPrefecture(?Prefecture $prefecture): self
    // {
    //     $this->prefecture = $prefecture;

    //     return $this;
    // }

   
    // public function getTribunal(): ?Tribunal
    // {
    //     return $this->tribunal;
    // }

    // public function setTribunal(?Tribunal $tribunal): self
    // {
    //     $this->tribunal = $tribunal;

    //     return $this;
    // }

    public function getLicence(): ?Licence
    {
        return $this->licence;
    }

    public function setLicence(?Licence $licence): self
    {
        if ($this->licence) {
            $this->licence->setStagiaire(null);
          }
        
          if ($licence !== null && $this !== $licence->getStagiaire()) {
            $licence->setStagiaire($this);
          }
        
          $this->licence = $licence;
        
          return $this;
        }
       

   
 /**
     * toString
     */
    public function __toString() {
        return $this->getCivilite() . ' ' . $this->getPrenomStagiaire() . ' ' . $this->getNomStagiaire();
    }

    public function getAvantage(): ?Avantage
    {
        return $this->avantage;
    }

    public function setAvantage(?Avantage $avantage): self
    {
        $this->avantage = $avantage;

        return $this;
    }

    
    public function getInfraction(): ?Infraction
    {
        return $this->infraction;
    }

    public function setInfraction(?Infraction $infraction): self
    {
        if ($this->infraction) {
            $this->infraction->setStagiaire(null);
          }
        
          if ($infraction !== null && $this !== $infraction->getStagiaire()) {
            $infraction->setStagiaire($this);
          }
        
          $this->infraction = $infraction;
        
          return $this;
        }

    /**
     * @param mixed $participations
     */
    public function getParticipations()
    {
        return $this->participations;
    }

    public function setParticipations( $participations)
    {
        $this->participations = $participations;
    }

    // On récupère participations pour les injecter dans notre champs "stage"
    // Permet de marquer les stages déjà sélectionnés dans la DB
    public function getStage()
    {
        $stages = new ArrayCollection();
        foreach($this->participations as $p)
        {
            $stages[] = $p->getStage();
        }
        return $stages;
    }
    public function setStage($stages)
    { 
        $this->stages = $stages;

        return $this;
    }
// On récupère participations pour les injecter dans notre champs "cas"
    // Permet de marquer le cas déjà sélectionnés dans la DB
    public function getCas()
    {
        $cass = new ArrayCollection();
        foreach($this->participations as $p)
        {
            $cass[] = $p->getCas();
        }
        return $cass;
    }
    public function setCas($cass)
    { 
        $this->cass = $cass;

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

    
}

