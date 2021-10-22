<?php

namespace App\Entity;

use App\Repository\ProfileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProfileRepository::class)
 */
class Profile
{
    use ResourceId;
    use Timestapable;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $description;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTimeInterface $dateNaissance;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $isRqth;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $isVisible;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $isAmenagement;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $portfolio;

    /**
     * @ORM\OneToMany(targetEntity=File::class, mappedBy="profile", cascade={"persist"})
     */
    private Collection $photo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $telephone;

    /**
     * @ORM\OneToMany(targetEntity=Adresse::class, mappedBy="profile")
     */
    private Collection $adresse;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="profile", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private ?User $user;

    /**
     * @ORM\ManyToOne(targetEntity=Dictionnaire::class, inversedBy="profilesContrat")
     */
    private ?Dictionnaire $typeContrat;

    /**
     * @ORM\ManyToOne(targetEntity=Dictionnaire::class, inversedBy="profilesSecteur")
     */
    private ?Dictionnaire $secteurActivite;

    /**
     * @ORM\ManyToOne(targetEntity=Dictionnaire::class, inversedBy="profilesEntretien")
     */
    private ?Dictionnaire $typeEntretien;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $recevoirAlertesOffres;

    /**
     * @ORM\Column(type="boolean")
     */
    private ?bool $isCvtheque;

    /**
     * @ORM\Column(type="boolean")
     */
    private ?bool $isRecevoirAlertes;

    /**
     * @ORM\Column(type="boolean")
     */
    private ?bool $isConditionsUtilisation;

    /**
     * @ORM\OneToMany(targetEntity=File::class, mappedBy="cv_candidat", cascade={"persist"})
     */
    private Collection $cv;

    /**
     * @ORM\ManyToOne(targetEntity=Dictionnaire::class, inversedBy="profilesDiplome")
     */
    private ?Dictionnaire $typeDiplome;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $ville;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $code_postal;

    /**
     * @ORM\ManyToOne(targetEntity=Dictionnaire::class, inversedBy="profilesLangues")
     */
    private ?Dictionnaire $Langues;

    /**
     * @ORM\ManyToOne(targetEntity=Dictionnaire::class, inversedBy="profilesNiveau")
     */
    private ?Dictionnaire $niveau;

    /**
     * @ORM\ManyToOne(targetEntity=Dictionnaire::class, inversedBy="profilesZoneGeographique")
     */
    private ?Dictionnaire $zonegeographique;

    public function __construct() {
        $this->isVisible = false;
        $this->createdAt = new \DateTimeImmutable('now');
        $this->photo = new ArrayCollection();
        $this->adresse = new ArrayCollection();
        $this->cv = new ArrayCollection();
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(?\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getIsRqth(): ?bool
    {
        return $this->isRqth;
    }

    public function setIsRqth(?bool $isRqth): self
    {
        $this->isRqth = $isRqth;

        return $this;
    }

    public function getIsVisible(): ?bool
    {
        return $this->isVisible;
    }

    public function setIsVisible(?bool $isVisible): self
    {
        $this->isVisible = $isVisible;

        return $this;
    }

    public function getIsAmenagement(): ?bool
    {
        return $this->isAmenagement;
    }

    public function setIsAmenagement(?bool $isAmenagement): self
    {
        $this->isAmenagement = $isAmenagement;

        return $this;
    }

    public function getPortfolio(): ?string
    {
        return $this->portfolio;
    }

    public function setPortfolio(?string $portfolio): self
    {
        $this->portfolio = $portfolio;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getPhoto(): Collection
    {
        return $this->photo;
    }

    public function addPhoto(File $photo): self
    {
        if (!$this->photo->contains($photo)) {
            $this->photo[] = $photo;
            $photo->setProfile($this);
        }

        return $this;
    }

    public function removePhoto(File $photo): self
    {
        if ($this->photo->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getProfile() === $this) {
                $photo->setProfile(null);
            }
        }

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getAdresse(): Collection
    {
        return $this->adresse;
    }

    public function addAdresse(Adresse $adresse): self
    {
        if (!$this->adresse->contains($adresse)) {
            $this->adresse[] = $adresse;
            $adresse->setProfile($this);
        }

        return $this;
    }

    public function removeAdresse(Adresse $adresse): self
    {
        if ($this->adresse->removeElement($adresse)) {
            // set the owning side to null (unless already changed)
            if ($adresse->getProfile() === $this) {
                $adresse->setProfile(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getTypeContrat(): ?Dictionnaire
    {
        return $this->typeContrat;
    }

    public function setTypeContrat(?Dictionnaire $typeContrat): self
    {
        $this->typeContrat = $typeContrat;

        return $this;
    }

    public function getSecteurActivite(): ?Dictionnaire
    {
        return $this->secteurActivite;
    }

    public function setSecteurActivite(?Dictionnaire $secteurActivite): self
    {
        $this->secteurActivite = $secteurActivite;

        return $this;
    }

    public function getTypeEntretien(): ?Dictionnaire
    {
        return $this->typeEntretien;
    }

    public function setTypeEntretien(?Dictionnaire $typeEntretien): self
    {
        $this->typeEntretien = $typeEntretien;

        return $this;
    }

    public function getRecevoirAlertesOffres(): ?bool
    {
        return $this->recevoirAlertesOffres;
    }

    public function setRecevoirAlertesOffres(?bool $recevoirAlertesOffres): self
    {
        $this->recevoirAlertesOffres = $recevoirAlertesOffres;

        return $this;
    }

    public function getIsCvtheque(): ?bool
    {
        return $this->isCvtheque;
    }

    public function setIsCvtheque(bool $isCvtheque): self
    {
        $this->isCvtheque = $isCvtheque;

        return $this;
    }

    public function getIsRecevoirAlertes(): ?bool
    {
        return $this->isRecevoirAlertes;
    }

    public function setIsRecevoirAlertes(bool $isRecevoirAlertes): self
    {
        $this->isRecevoirAlertes = $isRecevoirAlertes;

        return $this;
    }

    public function getIsConditionsUtilisation(): ?bool
    {
        return $this->isConditionsUtilisation;
    }

    public function setIsConditionsUtilisation(bool $isConditionsUtilisation): self
    {
        $this->isConditionsUtilisation = $isConditionsUtilisation;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getUser();
    }

    /**
     * @return Collection
     */
    public function getCv(): Collection
    {
        return $this->cv;
    }

    public function addCv(File $cv): self
    {
        if (!$this->cv->contains($cv)) {
            $this->cv[] = $cv;
            $cv->setCvCandidat($this);
        }

        return $this;
    }

    public function removeCv(File $cv): self
    {
        if ($this->cv->removeElement($cv)) {
            // set the owning side to null (unless already changed)
            if ($cv->getCvCandidat() === $this) {
                $cv->setCvCandidat(null);
            }
        }

        return $this;
    }

    public function getTypeDiplome(): ?Dictionnaire
    {
        return $this->typeDiplome;
    }

    public function setTypeDiplome(?Dictionnaire $typeDiplome): self
    {
        $this->typeDiplome = $typeDiplome;

        return $this;
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
        return $this->code_postal;
    }

    public function setCodePostal(?string $code_postal): self
    {
        $this->code_postal = $code_postal;

        return $this;
    }

    public function getLangues(): ?Dictionnaire
    {
        return $this->Langues;
    }

    public function setLangues(?Dictionnaire $Langues): self
    {
        $this->Langues = $Langues;

        return $this;
    }

    public function getNiveau(): ?Dictionnaire
    {
        return $this->niveau;
    }

    public function setNiveau(?Dictionnaire $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    public function getZonegeographique(): ?Dictionnaire
    {
        return $this->zonegeographique;
    }

    public function setZonegeographique(?Dictionnaire $zonegeographique): self
    {
        $this->zonegeographique = $zonegeographique;

        return $this;
    }
}
