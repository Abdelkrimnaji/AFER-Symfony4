<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CiviliteRepository")
 */
class Civilite
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
    private $nomCivilite;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Animateur", mappedBy="civilite")
     * 
     */
    private $animateurs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Stagiaire", mappedBy="civilite")
     * 
     */
    private $stagiaires;

    public function __construct()
    {
        $this->animateurs = new ArrayCollection();
        $this->stagiaires = new ArrayCollection();
    }

    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCivilite(): ?string
    {
        return $this->nomCivilite;
    }

    public function setNomCivilite(string $nomCivilite): self
    {
        $this->nomCivilite = $nomCivilite;

        return $this;
    }

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
            $animateur->setCivilite($this);
        }

        return $this;
    }

    public function removeAnimateur(Animateur $animateur): self
    {
        if ($this->animateurs->contains($animateur)) {
            $this->animateurs->removeElement($animateur);
            // set the owning side to null (unless already changed)
            if ($animateur->getCivilite() === $this) {
                $animateur->setCivilite(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Stagiaire[]
     */
    public function getStagiaires(): Collection
    {
        return $this->stagiaires;
    }

    public function addStagiaire(Stagiaire $stagiaire): self
    {
        if (!$this->stagiaires->contains($stagiaire)) {
            $this->stagiaires[] = $stagiaire;
            $stagiaire->setCivilite($this);
        }

        return $this;
    }

    public function removeStagiaire(Stagiaire $stagiaire): self
    {
        if ($this->stagiaires->contains($stagiaire)) {
            $this->stagiaires->removeElement($stagiaire);
            // set the owning side to null (unless already changed)
            if ($stagiaire->getCivilite() === $this) {
                $stagiaire->setCivilite($this);
            }
        }

        return $this;
    }

      
 /**
     * toString
     */
    public function __toString() {
        return $this->getNomCivilite();
    }

}
