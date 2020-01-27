<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TarifRepository")
 */
class Tarif
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $montantHt;

    /**
     * @ORM\Column(type="integer")
     */
    private $tva;

    /**
     * @ORM\Column(type="integer")
     */
    private $montantTtc;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Cas", mappedBy="tarifs")
     */
    private $cas;

    public function __construct()
    {
        $this->cas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontantHt(): ?int
    {
        return $this->montantHt;
    }

    public function setMontantHt(int $montantHt): self
    {
        $this->montantHt = $montantHt;

        return $this;
    }

    public function getTva(): ?int
    {
        return $this->tva;
    }

    public function setTva(int $tva): self
    {
        $this->tva = $tva;

        return $this;
    }

    public function getMontantTtc(): ?int
    {
        return $this->montantTtc;
    }

    public function setMontantTtc(int $montantTtc): self
    {
        $this->montantTtc = $montantTtc;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Cas[]
     */
    public function getCas(): Collection
    {
        return $this->cas;
    }

    public function addCa(Cas $ca): self
    {
        if (!$this->cas->contains($ca)) {
            $this->cas[] = $ca;
            $ca->setTarifs($this);
        }

        return $this;
    }

    public function removeCa(Cas $ca): self
    {
        if ($this->cas->contains($ca)) {
            $this->cas->removeElement($ca);
            // set the owning side to null (unless already changed)
            if ($ca->getTarifs() === $this) {
                $ca->setTarifs(null);
            }
        }

        return $this;
    }

    /**
     * toString
     */
    public function __toString() {
        return $this->getdescription();
    }

}
