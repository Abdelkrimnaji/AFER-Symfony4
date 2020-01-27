<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NatureInfractionRepository")
 */
class NatureInfraction
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
    private $nomInfraction;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Infraction", mappedBy="natureInfraction")
     */
    private $infractions;

    public function __construct()
    {
        $this->infractions = new ArrayCollection();
    }

       

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomInfraction(): ?string
    {
        return $this->nomInfraction;
    }

    public function setNomInfraction(string $nomInfraction): self
    {
        $this->nomInfraction = $nomInfraction;

        return $this;
    }

    

    /**
     * toString
     */
    public function __toString() {
        return $this->getNomInfraction();
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
            $infraction->addNatureInfraction($this);
        }

        return $this;
    }

    public function removeInfraction(Infraction $infraction): self
    {
        if ($this->infractions->contains($infraction)) {
            $this->infractions->removeElement($infraction);
            $infraction->removeNatureInfraction($this);
        }

        return $this;
    }
}
