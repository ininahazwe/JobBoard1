<?php

namespace App\Entity;

use App\Repository\AnnonceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=AnnonceRepository::class)
 */
class Annonce
{
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $reference;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $nombre_postes;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $description;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $qualites;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $salaire;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $horaires;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $adresse;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $avantages;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $accessibilite;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $statut;

    /**
     * @ORM\ManyToOne(targetEntity=Dictionnaire::class, inversedBy="annonces_diplome")
     */
    private ?Dictionnaire $diplome;

    /**
     * @ORM\ManyToOne(targetEntity=Dictionnaire::class, inversedBy="annonces_experience")
     */
    private ?Dictionnaire $experience;

    /**
     * @ORM\ManyToOne(targetEntity=Dictionnaire::class, inversedBy="annonces_contrat")
     */
    private ?Dictionnaire $contrat;

    /**
     * @ORM\ManyToMany(targetEntity=Dictionnaire::class, inversedBy="annonces_zone")
     * @ORM\JoinTable(name="annonces_zone")
     */
    private Collection $zone;

    /**
     * @ORM\ManyToMany(targetEntity=Dictionnaire::class, inversedBy="annonces_secteur")
     * @ORM\JoinTable(name="annonces_secteur")
     */
    private Collection $secteur;

    /**
     * @ORM\OneToMany(targetEntity=File::class, mappedBy="annonce", cascade={"persist"})
     */
    private Collection $documents;

    /**
     * @ORM\ManyToOne(targetEntity=Forum::class, inversedBy="annonces")
     */
    private ?Forum $forum;

    /**
     * @ORM\ManyToOne(targetEntity=Stand::class, inversedBy="annonces")
     */
    private ?Stand $stand;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTimeInterface $date_cloture;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="favoris")
     */
    private Collection $favoris;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="annonces_tags")
     */
    private Collection $tags;

    /**
     * @ORM\ManyToMany(targetEntity=Candidature::class, mappedBy="annonce")
     */
    private Collection $candidatures;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="annonce_recruteur")
     */
    private ?User $recruteur;

    public function __construct()
    {
        $this->setCreatedAt(new \DateTimeImmutable('now'));
        $this->zone = new ArrayCollection();
        $this->secteur = new ArrayCollection();
        $this->documents = new ArrayCollection();
        $this->favoris = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->candidatures = new ArrayCollection();
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

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getNombrePostes(): ?int
    {
        return $this->nombre_postes;
    }

    public function setNombrePostes(?int $nombre_postes): self
    {
        $this->nombre_postes = $nombre_postes;

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

    public function getQualites(): ?string
    {
        return $this->qualites;
    }

    public function setQualites(?string $qualites): self
    {
        $this->qualites = $qualites;

        return $this;
    }

    public function getSalaire(): ?string
    {
        return $this->salaire;
    }

    public function setSalaire(?string $salaire): self
    {
        $this->salaire = $salaire;

        return $this;
    }

    public function getHoraires(): ?string
    {
        return $this->horaires;
    }

    public function setHoraires(?string $horaires): self
    {
        $this->horaires = $horaires;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getAvantages(): ?string
    {
        return $this->avantages;
    }

    public function setAvantages(string $avantages): self
    {
        $this->avantages = $avantages;

        return $this;
    }

    public function getAccessibilite(): ?bool
    {
        return $this->accessibilite;
    }

    public function setAccessibilite(?bool $accessibilite): self
    {
        $this->accessibilite = $accessibilite;

        return $this;
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

    public function getDiplome(): ?Dictionnaire
    {
        return $this->diplome;
    }

    public function setDiplome(?Dictionnaire $diplome): self
    {
        $this->diplome = $diplome;

        return $this;
    }

    public function getExperience(): ?Dictionnaire
    {
        return $this->experience;
    }

    public function setExperience(?Dictionnaire $experience): self
    {
        $this->experience = $experience;

        return $this;
    }

    public function getContrat(): ?Dictionnaire
    {
        return $this->contrat;
    }

    public function setContrat(?Dictionnaire $contrat): self
    {
        $this->contrat = $contrat;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getZone(): Collection
    {
        return $this->zone;
    }

    public function addZone(Dictionnaire $zone): self
    {
        if (!$this->zone->contains($zone)) {
            $this->zone[] = $zone;
        }

        return $this;
    }

    public function removeZone(Dictionnaire $zone): self
    {
        $this->zone->removeElement($zone);

        return $this;
    }

    /**
     * @return Collection
     */
    public function getSecteur(): Collection
    {
        return $this->secteur;
    }

    public function addSecteur(Dictionnaire $secteur): self
    {
        if (!$this->secteur->contains($secteur)) {
            $this->secteur[] = $secteur;
        }

        return $this;
    }

    public function removeSecteur(Dictionnaire $secteur): self
    {
        $this->secteur->removeElement($secteur);

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
            $document->setAnnonce($this);
        }

        return $this;
    }

    public function removeDocument(File $document): self
    {
        if ($this->documents->removeElement($document)) {
            // set the owning side to null (unless already changed)
            if ($document->getAnnonce() === $this) {
                $document->setAnnonce(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->nom;
    }

    public function getForum(): ?Forum
    {
        return $this->forum;
    }

    public function setForum(?Forum $forum): self
    {
        $this->forum = $forum;

        return $this;
    }

    public function getStand(): ?Stand
    {
        return $this->stand;
    }

    public function setStand(?Stand $stand): self
    {
        $this->stand = $stand;

        return $this;
    }

    public function getDateCloture(): ?\DateTimeInterface
    {
        return $this->date_cloture;
    }

    public function setDateCloture(?\DateTimeInterface $date_cloture): self
    {
        $this->date_cloture = $date_cloture;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getFavoris(): Collection
    {
        return $this->favoris;
    }

    public function addFavori(User $favori): self
    {
        if (!$this->favoris->contains($favori)) {
            $this->favoris[] = $favori;
        }

        return $this;
    }

    public function removeFavori(User $favori): self
    {
        $this->favoris->removeElement($favori);

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tags->removeElement($tag);

        return $this;
    }

    /**
     * @return Collection|Candidature[]
     */
    public function getCandidatures(): Collection
    {
        return $this->candidatures;
    }

    public function addCandidature(Candidature $candidature): self
    {
        if (!$this->candidatures->contains($candidature)) {
            $this->candidatures[] = $candidature;
            $candidature->addAnnonce($this);
        }

        return $this;
    }

    public function removeCandidature(Candidature $candidature): self
    {
        if ($this->candidatures->removeElement($candidature)) {
            $candidature->removeAnnonce($this);
        }

        return $this;
    }

    public function getRecruteur(): ?User
    {
        return $this->recruteur;
    }

    public function setRecruteur(?User $recruteur): self
    {
        $this->recruteur = $recruteur;

        return $this;
    }
}
