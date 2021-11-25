<?php

namespace App\Entity;

use App\Repository\ForumRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=ForumRepository::class)
 */
class Forum
{
    const OUVERT = 1;
    const FERME = 0;

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
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTimeInterface $date_ouverture;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTimeInterface $date_fermeture;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $statut;

    /**
     * @ORM\ManyToOne(targetEntity=Dictionnaire::class, inversedBy="forumsOpeningStatus")
     */
    private ?Dictionnaire $opening_statut;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTimeInterface $date_fermeture_candidature;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $description;

    /**
     * @ORM\ManyToMany(targetEntity=Pavillon::class, inversedBy="forums", cascade={"persist", "remove"})
     */
    private Collection $pavillon;

    /**
     * @ORM\ManyToMany(targetEntity=Stand::class, inversedBy="forums", cascade={"persist", "remove"})
     */
    private Collection $stand;

    /**
     * @ORM\OneToMany(targetEntity=File::class, mappedBy="forum", cascade={"persist"})
     */
    private Collection $logo;

    /**
     * @ORM\OneToMany(targetEntity=Annonce::class, mappedBy="forum")
     */
    private Collection $annonces;

    /**
     * @ORM\OneToMany(targetEntity=Animation::class, mappedBy="forum")
     */
    private $animations;

    public function __construct()
    {
        $this->pavillon = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable('now');
        $this->stand = new ArrayCollection();
        $this->logo = new ArrayCollection();
        $this->annonces = new ArrayCollection();
        $this->animations = new ArrayCollection();
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

    public function getDateOuverture(): ?\DateTimeInterface
    {
        return $this->date_ouverture;
    }

    public function setDateOuverture(?\DateTimeInterface $date_ouverture): self
    {
        $this->date_ouverture = $date_ouverture;

        return $this;
    }

    public function getDateFermeture(): ?\DateTimeInterface
    {
        return $this->date_fermeture;
    }

    public function setDateFermeture(?\DateTimeInterface $date_fermeture): self
    {
        $this->date_fermeture = $date_fermeture;

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

    public function getOpeningStatut(): ?Dictionnaire
    {
        return $this->opening_statut;
    }

    public function setOpeningStatut(?Dictionnaire $opening_statut): self
    {
        $this->opening_statut = $opening_statut;

        return $this;
    }

    public function getDateFermetureCandidature(): ?\DateTimeInterface
    {
        return $this->date_fermeture_candidature;
    }

    public function setDateFermetureCandidature(?\DateTimeInterface $date_fermeture_candidature): self
    {
        $this->date_fermeture_candidature = $date_fermeture_candidature;

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

    /**
     * @return Collection
     */
    public function getPavillon(): Collection
    {
        return $this->pavillon;
    }

    public function addPavillon(Pavillon $pavillon): self
    {
        if (!$this->pavillon->contains($pavillon)) {
            $this->pavillon[] = $pavillon;
        }

        return $this;
    }

    public function removePavillon(Pavillon $pavillon): self
    {
        $this->pavillon->removeElement($pavillon);

        return $this;
    }

    /**
     * @return Collection
     */
    public function getStand(): Collection
    {
        return $this->stand;
    }

    public function addStand(Stand $stand): self
    {
        if (!$this->stand->contains($stand)) {
            $this->stand[] = $stand;
        }

        return $this;
    }

    public function removeStand(Stand $stand): self
    {
        $this->stand->removeElement($stand);

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
            $logo->setForum($this);
        }

        return $this;
    }

    public function removeLogo(File $logo): self
    {
        if ($this->logo->removeElement($logo)) {
            // set the owning side to null (unless already changed)
            if ($logo->getForum() === $this) {
                $logo->setForum(null);
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
            $annonce->setForum($this);
        }

        return $this;
    }

    public function removeAnnonce(Annonce $annonce): self
    {
        if ($this->annonces->removeElement($annonce)) {
            // set the owning side to null (unless already changed)
            if ($annonce->getForum() === $this) {
                $annonce->setForum(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Animation[]
     */
    public function getAnimations(): Collection
    {
        return $this->animations;
    }

    public function addAnimation(Animation $animation): self
    {
        if (!$this->animations->contains($animation)) {
            $this->animations[] = $animation;
            $animation->setForum($this);
        }

        return $this;
    }

    public function removeAnimation(Animation $animation): self
    {
        if ($this->animations->removeElement($animation)) {
            // set the owning side to null (unless already changed)
            if ($animation->getForum() === $this) {
                $animation->setForum(null);
            }
        }

        return $this;
    }
}
