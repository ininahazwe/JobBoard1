<?php

namespace App\Entity;

use App\Repository\AdresseRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdresseRepository::class)
 */
class Adresse
{
    Use ResourceId;
    Use Timestapable;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $ville;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $codePostal;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $departement;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $adresseComplete;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $complement;

    /**
     * @ORM\ManyToOne(targetEntity=Profile::class, inversedBy="adresse")
     */
    private ?Profile $profile;

    public function __construct() {
        $this->createdAt = new \DateTimeImmutable('now');
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(?string $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getDepartement(): ?string
    {
        return $this->departement;
    }

    public function setDepartement(?string $departement): self
    {
        $this->departement = $departement;

        return $this;
    }

    public function getAdresseComplete(): ?string
    {
        return $this->adresseComplete;
    }

    public function setAdresseComplete(?string $adresseComplete): self
    {
        $this->adresseComplete = $adresseComplete;

        return $this;
    }

    public function getComplement(): ?string
    {
        return $this->complement;
    }

    public function setComplement(?string $complement): self
    {
        $this->complement = $complement;

        return $this;
    }

    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    public function setProfile(?Profile $profile): self
    {
        $this->profile = $profile;

        return $this;
    }
}
