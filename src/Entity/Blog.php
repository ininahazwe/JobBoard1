<?php

namespace App\Entity;

use App\Repository\BlogRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=BlogRepository::class)
 */
class Blog
{
    use ResourceId;
    use Timestapable;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $titre;

    /**
     * @ORM\ManyToOne(targetEntity=Dictionnaire::class, inversedBy="blogs")
     */
    private ?Dictionnaire $type;

    /**
     * @ORM\OneToMany(targetEntity=File::class, mappedBy="blog", cascade={"persist"})
     */
    private Collection $images;

    /**
     * @ORM\ManyToOne(targetEntity=Dictionnaire::class, inversedBy="blog_faq")
     */
    private ?Dictionnaire $faq;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $isStatut;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $description;

    /**
     * @Gedmo\Slug(fields={"titre"})
     * @ORM\Column(type="string", length=255)
     */
    private ?string $slug;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="blogs")
     */
    private Collection $auteur;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="blogs")
     */
    private Collection $tag;

    public function __construct()
    {
        $this->setCreatedAt(new \DateTimeImmutable('now'));
        $this->images = new ArrayCollection();
        $this->auteur = new ArrayCollection();
        $this->tag = new ArrayCollection();
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): self
    {
        $this->titre = $titre;

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

    /**
     * @return Collection
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(File $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setBlog($this);
        }

        return $this;
    }

    public function removeImage(File $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getBlog() === $this) {
                $image->setBlog(null);
            }
        }

        return $this;
    }

    public function getFaq(): ?Dictionnaire
    {
        return $this->faq;
    }

    public function setFaq(?Dictionnaire $faq): self
    {
        $this->faq = $faq;

        return $this;
    }

    public function getIsStatut(): ?bool
    {
        return $this->isStatut;
    }

    public function setIsStatut(?bool $isStatut): self
    {
        $this->isStatut = $isStatut;

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @return Collection
     */
    public function getAuteur(): Collection
    {
        return $this->auteur;
    }

    public function addAuteur(User $auteur): self
    {
        if (!$this->auteur->contains($auteur)) {
            $this->auteur[] = $auteur;
        }

        return $this;
    }

    public function removeAuteur(User $auteur): self
    {
        $this->auteur->removeElement($auteur);

        return $this;
    }

    /**
     * @return Collection
     */
    public function getTag(): Collection
    {
        return $this->tag;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tag->contains($tag)) {
            $this->tag[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tag->removeElement($tag);

        return $this;
    }
}
