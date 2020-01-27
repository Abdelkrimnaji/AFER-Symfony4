<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LicenceRepository")
 */
class Licence
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $licenceNumber;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $licenceDate;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Stagiaire", mappedBy="licence")
     */
    private $stagiaire;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Prefecture", inversedBy="licences")
     */
    private $prefecture;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLicenceNumber(): ?string
    {
        return $this->licenceNumber;
    }

    public function setLicenceNumber(?string $licenceNumber): self
    {
        $this->licenceNumber = $licenceNumber;

        return $this;
    }

    public function getLicenceDate(): ?\DateTimeInterface
    {
        return $this->licenceDate;
    }

    public function setLicenceDate(?\DateTimeInterface $licenceDate): self
    {
        $this->licenceDate = $licenceDate;

        return $this;
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

    public function getPrefecture(): ?Prefecture
    {
        return $this->prefecture;
    }

    public function setPrefecture(?Prefecture $prefecture): self
    {
        $this->prefecture = $prefecture;

        return $this;
    }

      
 /**
     * toString
     */
    public function __toString() {
        if(is_null($this->getLicenceNumber())) {
            return 'NULL';
        }
        
        return $this->getLicenceNumber();
    }
}
