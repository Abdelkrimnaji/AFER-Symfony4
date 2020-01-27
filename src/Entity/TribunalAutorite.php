<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TribunalAutoriteRepository")
 * @UniqueEntity(
 * fields={"nom"},
 * message="L'autorité existe déjà")
 */
class TribunalAutorite
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message="Veuillez insérer le nom d'une autorité.")
     * @Assert\Length(min = 2, max = 100 , minMessage = "La valeur insérée doit être comprise entre 2 et 100 caractères", maxMessage = "La valeur insérée doit être comprise entre 2 et 100 caractères")
     * 
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Tribunal", mappedBy="tribunalAutorite")
     */
    private $relation;

    public function __construct()
    {
        $this->relation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection|Tribunal[]
     */
    public function getRelation(): Collection
    {
        return $this->relation;
    }

    public function addRelation(Tribunal $relation): self
    {
        if (!$this->relation->contains($relation)) {
            $this->relation[] = $relation;
            $relation->setTribunalAutorite($this);
        }

        return $this;
    }

    public function removeRelation(Tribunal $relation): self
    {
        if ($this->relation->contains($relation)) {
            $this->relation->removeElement($relation);
            // set the owning side to null (unless already changed)
            if ($relation->getTribunalAutorite() === $this) {
                $relation->setTribunalAutorite(null);
            }
        }

        return $this;
    }

    /**
    * toString
    * 
    */
    public function __toString(){
        return $this->getNom();
    }
}
