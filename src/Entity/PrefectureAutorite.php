<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PrefectureAutoriteRepository")
 * @UniqueEntity(
 * fields={"nom"},
 * message="L'autorité existe déjà")
 */
class PrefectureAutorite
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=45)
     * @Assert\NotBlank(message="Veuillez insérer un nom.")
     * @Assert\Length(min = 2, max = 45, minMessage = "La valeur inséré doit être comprise entre 2 et 45 caractères", maxMessage = "La valeur inséré doit être comprise entre 2 et 45 caractères")
     * 
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Prefecture", mappedBy="prefectureAutorite")
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
     * @return Collection|Prefecture[]
     */
    public function getRelation(): Collection
    {
        return $this->relation;
    }

    public function addRelation(Prefecture $relation): self
    {
        if (!$this->relation->contains($relation)) {
            $this->relation[] = $relation;
            $relation->setPrefectureAutorite($this);
        }

        return $this;
    }

    public function removeRelation(Prefecture $relation): self
    {
        if ($this->relation->contains($relation)) {
            $this->relation->removeElement($relation);
            // set the owning side to null (unless already changed)
            if ($relation->getPrefectureAutorite() === $this) {
                $relation->setPrefectureAutorite(null);
            }
        }

        return $this;
    }

    /**
     * toString
     */
    public function __toString() {
        return $this->getNom();
    }
}
