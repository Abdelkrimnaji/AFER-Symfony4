<?php

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TribunalRepository")
 */
class Tribunal
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message="Veuillez insérer le nom du tribunal.")
     * @Assert\Length(min = 2, max = 45, minMessage = "La valeur insérée doit être comprise entre 2 et 45 caractères", maxMessage = "La valeur insérée doit être comprise entre 2 et 45 caractères")
     */
    private $nomTribunal;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min = 2, max = 255 , minMessage = "La valeur insérée doit être comprise entre 2 et 255 caractères", maxMessage = "La valeur insérée doit être comprise entre 2 et 255 caractères")
     */
    private $adresseTribunal;

    /**
     * @ORM\Column(type="string", length=45)
     * @Assert\Length(min = 1, max = 45, minMessage = "La valeur insérée doit être comprise entre 1 et 45 caractères", maxMessage = "La valeur inséré doit être comprise entre 1 et 45 caractères")
     */
    private $numeroAdresseTribunal;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $communeTribunal;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TribunalService", inversedBy="relation")
     */
    private $tribunalService;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TribunalAutorite", inversedBy="relation")
     */
    private $tribunalAutorite;
    //  /**
    //  * @ORM\OneToMany(targetEntity="App\Entity\Stage", mappedBy="tribunal")
    //  */
    // private $stages;

    // /**
    //  * @ORM\OneToMany(targetEntity="App\Entity\Stagiaire", mappedBy="tribunal")
    //  */
    // private $stagiaires;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Infraction", mappedBy="tribunal")
     */
    private $infractions;

    

    public function __construct()
    {
        // $this->stage = new ArrayCollection();
        // $this->stagiaires = new ArrayCollection();
        $this->infractions = new ArrayCollection();
       
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomTribunal(): ?string
    {
        return $this->nomTribunal;
    }

    public function setNomTribunal(string $nomTribunal): self
    {
        $this->nomTribunal = $nomTribunal;

        return $this;
    }

    public function getAdresseTribunal(): ?string
    {
        return $this->adresseTribunal;
    }

    public function setAdresseTribunal(string $adresseTribunal): self
    {
        $this->adresseTribunal = $adresseTribunal;

        return $this;
    }

    public function getNumeroAdresseTribunal(): ?string
    {
        return $this->numeroAdresseTribunal;
    }

    public function setNumeroAdresseTribunal(string $numeroAdresseTribunal): self
    {
        $this->numeroAdresseTribunal = $numeroAdresseTribunal;

        return $this;
    }
    
    public function getCommuneTribunal(): ?string
    {
        return $this->communeTribunal;
    }

    public function setCommuneTribunal(string $communeTribunal): self
    {
        $this->communeTribunal = $communeTribunal;

        return $this;
    }

    public function getTribunalService(): ?TribunalService
    {
        return $this->tribunalService;
    }

    public function setTribunalService(?TribunalService $tribunalService): self
    {
        $this->tribunalService = $tribunalService;
        return $this;
    }

    public function getTribunalAutorite(): ?TribunalAutorite
    {
        return $this->tribunalAutorite;
    }

    public function setTribunalAutorite(?TribunalAutorite $tribunalAutorite): self
    {
        $this->tribunalAutorite = $tribunalAutorite;

        return $this;
    }
    
//    /**
//      * @return Collection|Stage[]
//      */
//     public function getStages(): Collection
//     {
//         return $this->stages;
//     }

//     public function addStage(Stage $stage): self
//     {
//         if (!$this->stages->contains($stage)) {
//             $this->stages[] = $stage;
//             $stage->addStage($this);
//         }
//         return $this;
//     }
//     public function removeStage(Stage $stage): self
//     {
//         if ($this->stages->contains($stage)) {
//             $this->stages->removeElement($stage);
//              // set the owning side to null (unless already changed)
//              if ($stage->getTribunal() === $this) {
//                 $stage->setTribunal(null);
           
//         }
//     }
//         return $this;
//     }

    // /**
    //  * @return Collection|Stagiaire[]
    //  */
    // public function getStagiaires(): Collection
    // {
    //     return $this->stagiaires;
    // }

    // public function addStagiaire(Stagiaire $stagiaire): self
    // {
    //     if (!$this->stagiaires->contains($stagiaire)) {
    //         $this->stagiaires[] = $stagiaire;
    //         $stagiaire->addTribunal($this);
    //     }

    //     return $this;
    // }

    // public function removeStagiaire(Stagiaire $stagiaire): self
    // {
    //     if ($this->stagiaires->contains($stagiaire)) {
    //         $this->stagiaires->removeElement($stagiaire);
    //         $stagiaire->removeTribunal($this);
    //     }

    //     return $this;
    // }

      
 /**
     * toString
     */
    public function __toString() {
        return $this->getNomTribunal();
    }

    /**
     * @return Collection|Infraction[]
     */
    public function getInfractions(): Collection
    {
        return $this->infractions;
    }

    public function addInfraction(Infraction $infraction): self
    {
        if (!$this->infractions->contains($infraction)) {
            $this->infractions[] = $infraction;
            $infraction->setTribunal($this);
        }

        return $this;
    }

    public function removeInfraction(Infraction $infraction): self
    {
        if ($this->infractions->contains($infraction)) {
            $this->infractions->removeElement($infraction);
            // set the owning side to null (unless already changed)
            if ($infraction->getTribunal() === $this) {
                $infraction->setTribunal(null);
            }
        }

        return $this;
    }
    



}
