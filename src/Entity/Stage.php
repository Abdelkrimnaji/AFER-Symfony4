<?php
namespace App\Entity;

use App\Entity\DateTimeInterface;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StageRepository")
 * @UniqueEntity(
 * fields={"numeroStage"},
 * message="Le stage existe déjà")
 */
class Stage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=45, nullable=false)
     * @Assert\Length(min = 2, max = 45, minMessage = "La valeur insérée doit être comprise entre 2 et 45 caractères", maxMessage = "La valeur insérée doit être comprise entre 2 et 45 caractères")
     */
    private $numeroStage;
    /**
     * @ORM\Column(type="date")
     * @Assert\GreaterThanOrEqual("today", message = "La date de début de stage doit être supérieure ou égale à la date d'aujourd'hui")
     */
    private $dated;
    /**
     * @ORM\Column(type="date")
     * @Assert\GreaterThan(propertyPath="dated", message = "La date de fin de stage doit être supérieure à la date de début de stage")
     */
    private $datef;
    /**
     * @ORM\Column(type="boolean")
     */
    private $stageProgrammeOfficiel;

    // /**
    //  * @ORM\ManyToOne(targetEntity="App\Entity\Prefecture", inversedBy="stages")
    //  * @ORM\JoinColumn(nullable=true)
    //  */
    // private $prefecture;

    // /**
    //  * @ORM\ManyToOne(targetEntity="App\Entity\Tribunal", inversedBy="stages")
    //  * @ORM\JoinColumn(nullable=true)
    //  */
    // private $tribunal;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Animateur", inversedBy="stages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $animateurs;

        /**
     * @ORM\ManyToOne(targetEntity="App\Entity\LieuStage", inversedBy="stages")
     */
    private $lieuStage;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Participation", mappedBy="stage", cascade={"persist"})
     */
    private $participations;

 

    public function __construct()
    {
        $this->animateurs = new ArrayCollection();
        $this->participations = new ArrayCollection();
               
    }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getNumeroStage(): ?string
    {
        return $this->numeroStage;
    }
    public function setNumeroStage(string $numeroStage): self
    {
        $this->numeroStage = $numeroStage;
        return $this;
    }
    public function getDated(): ?\DateTimeInterface
    {
        return $this->dated;
    }
    public function setDated(\DateTimeInterface $dated): self
    {
        $this->dated = $dated;
        return $this;
    }
    public function getDatef(): ?\DateTimeInterface
    {
        return $this->datef;
    }
    public function setDatef(\DateTimeInterface $datef): self
    {
        $this->datef = $datef;
        return $this;
    }
    public function getStageProgrammeOfficiel(): ?bool
    {
        return $this->stageProgrammeOfficiel;
    }
    public function setStageProgrammeOfficiel(bool $stageProgrammeOfficiel): self
    {
        $this->stageProgrammeOfficiel = $stageProgrammeOfficiel;
        return $this;
    }

    // public function getPrefecture(): ?prefecture
    // {
    //     return $this->prefecture;
    // }

    // public function setPrefecture(?prefecture $prefecture): self
    // {
    //     $this->prefecture = $prefecture;

    //     return $this;
    // }

    // public function getTribunal(): ?tribunal
    // {
    //     return $this->tribunal;
    // }

    // public function setTribunal(?tribunal $tribunal): self
    // {
    //     $this->tribunal = $tribunal;

    //     return $this;
    // }

    /**
     * @return Collection|Animateur[]
     */
    public function getAnimateurs(): Collection
    {
        return $this->animateurs;
    }

    public function addAnimateur(Animateur $animateur): self
    {
        if (!$this->animateurs->contains($animateur)) {
            $this->animateurs[] = $animateur;
            $animateur->addAnimateur($this);
        }

        return $this;
    }

    public function removeAnimateur(Animateur $animateur): self
    {
        if ($this->animateurs->contains($animateur)) {
            $this->animateurs->removeElement($animateur);
            $animateur->removeAnimateur($this);
        }

        return $this;
    }

    

    public function getLieuStage(): ?LieuStage
    {
        return $this->lieuStage;
    }

    public function setLieuStage(?LieuStage $lieuStage): self
    {
        $this->lieuStage = $lieuStage;

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
        
// On récupère participations pour les injecter dans notre champs "stagiaire"
    // Permet de marquer les stagiaires déjà sélectionnés dans la DB
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
        return $this->getNumeroStage();
    }

}
