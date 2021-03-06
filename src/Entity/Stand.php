<?php

namespace App\Entity;

use App\Repository\StandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=StandRepository::class)
 */
class Stand
{
    const PUBLIE = 1;
    const DEPUBLIE = 0;

    use ResourceId;
    use Timestapable;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $nom;

    /**
     * @Gedmo\Slug(fields={"nom"})
     * @ORM\Column(type="string", length=255)
     */
    private ?string $slug;

    /**
     * @ORM\ManyToMany(targetEntity=Forum::class, mappedBy="stand")
     */
    private Collection $forums;

    /**
     * @ORM\ManyToOne(targetEntity=Dictionnaire::class, inversedBy="stands")
     */
    private ?Dictionnaire $type;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $statut;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $cvtheque;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $vivier_candidat;

    /**
     * @ORM\Column(type="boolean")
     */
    private ?bool $parametres_recruteur;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $speed_meeting;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $nombre_participation_canditat_stand;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $code_inscription;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $url;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $description;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $page_offres;

    /**
     * @ORM\OneToMany(targetEntity=File::class, mappedBy="stand", cascade={"persist"})
     */
    private Collection $logo;

    /**
     * @ORM\OneToMany(targetEntity=Annonce::class, mappedBy="stand")
     */
    private Collection $annonces;

    /**
     * @ORM\OneToMany(targetEntity=File::class, mappedBy="stand_documents", cascade={"persist"})
     */
    private Collection $documents;

    /**
     * @ORM\OneToMany(targetEntity=Questionnaire::class, mappedBy="stand")
     */
    private Collection $questionnaires;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $isUne;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="stands_favoris")
     */
    private Collection $favoris_stand;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="stand_gestionnaires")
     * @ORM\JoinTable(name="stand_gestionnaires")
     */
    private Collection $gestionnaire;

    /**
     * @ORM\OneToMany(targetEntity=Speedmeeting::class, mappedBy="stand")
     */
    private Collection $speedmeetings;

    /**
     * @ORM\OneToMany(targetEntity=Candidature::class, mappedBy="stand")
     */
    private Collection $candidatures;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?bool $regroupement_candidatures;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable('now');
        $this->forums = new ArrayCollection();
        $this->annonces = new ArrayCollection();
        $this->logo = new ArrayCollection();
        $this->documents = new ArrayCollection();
        $this->questionnaires = new ArrayCollection();
        $this->favoris_stand = new ArrayCollection();
        $this->gestionnaire = new ArrayCollection();
        $this->speedmeetings = new ArrayCollection();
        $this->candidatures = new ArrayCollection();
    }

    /**
     * @return Collection
     */
    public function getForums(): Collection
    {
        return $this->forums;
    }

    public function addForum(Forum $forum): self
    {
        if (!$this->forums->contains($forum)) {
            $this->forums[] = $forum;
            $forum->addStand($this);
        }

        return $this;
    }

    public function removeForum(Forum $forum): self
    {
        if ($this->forums->removeElement($forum)) {
            $forum->removeStand($this);
        }

        return $this;
    }

    public function getType(): ?Dictionnaire
    {
        return $this->type;
    }

    public function setType(?Dictionnaire $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function getStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(?bool $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getCvtheque(): ?bool
    {
        return $this->cvtheque;
    }

    public function setCvtheque(?bool $cvtheque): self
    {
        $this->cvtheque = $cvtheque;

        return $this;
    }

    public function getVivierCandidat(): ?bool
    {
        return $this->vivier_candidat;
    }

    public function setVivierCandidat(?bool $vivier_candidat): self
    {
        $this->vivier_candidat = $vivier_candidat;

        return $this;
    }

    public function getParametresRecruteur(): ?bool
    {
        return $this->parametres_recruteur;
    }

    public function setParametresRecruteur(bool $parametres_recruteur): self
    {
        $this->parametres_recruteur = $parametres_recruteur;

        return $this;
    }

    public function getSpeedMeeting(): ?bool
    {
        return $this->speed_meeting;
    }

    public function setSpeedMeeting(?bool $speed_meeting): self
    {
        $this->speed_meeting = $speed_meeting;

        return $this;
    }

    public function getNombreParticipationCanditatStand(): ?bool
    {
        return $this->nombre_participation_canditat_stand;
    }

    public function setNombreParticipationCanditatStand(?bool $nombre_participation_canditat_stand): self
    {
        $this->nombre_participation_canditat_stand = $nombre_participation_canditat_stand;

        return $this;
    }

    public function getCodeInscription(): ?string
    {
        return $this->code_inscription;
    }

    public function setCodeInscription(?string $code_inscription): self
    {
        $this->code_inscription = $code_inscription;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
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

    public function getPageOffres(): ?string
    {
        return $this->page_offres;
    }

    public function setPageOffres(?string $page_offres): self
    {
        $this->page_offres = $page_offres;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getLogo(): Collection
    {
        return $this->logo;
    }

    public function addLogo(File $logo): self
    {
        if (!$this->logo->contains($logo)) {
            $this->logo[] = $logo;
            $logo->setStand($this);
        }

        return $this;
    }

    public function removeLogo(File $logo): self
    {
        if ($this->logo->removeElement($logo)) {
            // set the owning side to null (unless already changed)
            if ($logo->getStand() === $this) {
                $logo->setStand(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->nom;
    }

    /**
     * @return Collection
     */
    public function getAnnonces(): Collection
    {
        return $this->annonces;
    }

    public function addAnnonce(Annonce $annonce): self
    {
        if (!$this->annonces->contains($annonce)) {
            $this->annonces[] = $annonce;
            $annonce->setStand($this);
        }

        return $this;
    }

    public function removeAnnonce(Annonce $annonce): self
    {
        if ($this->annonces->removeElement($annonce)) {
            // set the owning side to null (unless already changed)
            if ($annonce->getStand() === $this) {
                $annonce->setStand(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    public function addDocument(File $document): self
    {
        if (!$this->documents->contains($document)) {
            $this->documents[] = $document;
            $document->setStandDocuments($this);
        }

        return $this;
    }

    public function removeDocument(File $document): self
    {
        if ($this->documents->removeElement($document)) {
            // set the owning side to null (unless already changed)
            if ($document->getStandDocuments() === $this) {
                $document->setStandDocuments(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getQuestionnaires(): Collection
    {
        return $this->questionnaires;
    }

    public function addQuestionnaire(Questionnaire $questionnaire): self
    {
        if (!$this->questionnaires->contains($questionnaire)) {
            $this->questionnaires[] = $questionnaire;
            $questionnaire->setStand($this);
        }

        return $this;
    }

    public function removeQuestionnaire(Questionnaire $questionnaire): self
    {
        if ($this->questionnaires->removeElement($questionnaire)) {
            // set the owning side to null (unless already changed)
            if ($questionnaire->getStand() === $this) {
                $questionnaire->setStand(null);
            }
        }

        return $this;
    }

    public function getIsUne(): ?bool
    {
        return $this->isUne;
    }

    public function setIsUne(?bool $isUne): self
    {
        $this->isUne = $isUne;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getFavorisStand(): Collection
    {
        return $this->favoris_stand;
    }

    public function addFavorisStand(User $favorisStand): self
    {
        if (!$this->favoris_stand->contains($favorisStand)) {
            $this->favoris_stand[] = $favorisStand;
        }

        return $this;
    }

    public function removeFavorisStand(User $favorisStand): self
    {
        $this->favoris_stand->removeElement($favorisStand);

        return $this;
    }

    /**
     * @return Collection
     */
    public function getGestionnaire(): Collection
    {
        return $this->gestionnaire;
    }

    public function addGestionnaire(User $gestionnaire): self
    {
        if (!$this->gestionnaire->contains($gestionnaire)) {
            $this->gestionnaire[] = $gestionnaire;
        }

        return $this;
    }

    public function removeGestionnaire(User $gestionnaire): self
    {
        $this->gestionnaire->removeElement($gestionnaire);

        return $this;
    }

    /**
     * @return Collection
     */
    public function getSpeedmeetings(): Collection
    {
        return $this->speedmeetings;
    }

    public function addSpeedmeeting(Speedmeeting $speedmeeting): self
    {
        if (!$this->speedmeetings->contains($speedmeeting)) {
            $this->speedmeetings[] = $speedmeeting;
            $speedmeeting->setStand($this);
        }

        return $this;
    }

    public function removeSpeedmeeting(Speedmeeting $speedmeeting): self
    {
        if ($this->speedmeetings->removeElement($speedmeeting)) {
            // set the owning side to null (unless already changed)
            if ($speedmeeting->getStand() === $this) {
                $speedmeeting->setStand(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getCandidatures(): Collection
    {
        return $this->candidatures;
    }

    public function addCandidature(Candidature $candidature): self
    {
        if (!$this->candidatures->contains($candidature)) {
            $this->candidatures[] = $candidature;
            $candidature->setStand($this);
        }

        return $this;
    }

    public function removeCandidature(Candidature $candidature): self
    {
        if ($this->candidatures->removeElement($candidature)) {
            // set the owning side to null (unless already changed)
            if ($candidature->getStand() === $this) {
                $candidature->setStand(null);
            }
        }

        return $this;
    }

    public function getRegroupementCandidatures(): ?bool
    {
        return $this->regroupement_candidatures;
    }

    public function setRegroupementCandidatures(?bool $regroupement_candidatures): self
    {
        $this->regroupement_candidatures = $regroupement_candidatures;

        return $this;
    }

    public function isRegroupementCandidature(): bool
    {
        if($this->regroupement_candidatures == 1 ){
            return true;
        }
        return false;
    }

}
