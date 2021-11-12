<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=TagRepository::class)
 */
class Tag
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
     * @ORM\ManyToMany(targetEntity=Profile::class, inversedBy="tags")
     */
    private Collection $competences;

    /**
     * @ORM\ManyToMany(targetEntity=Blog::class, mappedBy="tag")
     */
    private Collection $blogs;

    /**
     * @ORM\ManyToMany(targetEntity=Annonce::class, mappedBy="tags")
     */
    private Collection $annonces_tags;

    public function __construct()
    {
        $this->competences = new ArrayCollection();
        $this->setCreatedAt(new \DateTimeImmutable('now'));
        $this->blogs = new ArrayCollection();
        $this->annonces_tags = new ArrayCollection();
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


    /**
     * @return Collection
     */
    public function getCompetences(): Collection
    {
        return $this->competences;
    }

    public function addCompetence(Profile $competence): self
    {
        if (!$this->competences->contains($competence)) {
            $this->competences[] = $competence;
        }

        return $this;
    }

    public function removeCompetence(Profile $competence): self
    {
        $this->competences->removeElement($competence);

        return $this;
    }

    /**
     * @return Collection
     */
    public function getBlogs(): Collection
    {
        return $this->blogs;
    }

    public function addBlog(Blog $blog): self
    {
        if (!$this->blogs->contains($blog)) {
            $this->blogs[] = $blog;
            $blog->addTag($this);
        }

        return $this;
    }

    public function removeBlog(Blog $blog): self
    {
        if ($this->blogs->removeElement($blog)) {
            $blog->removeTag($this);
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->nom;
    }

    /**
     * @return Collection|Annonce[]
     */
    public function getAnnoncesTags(): Collection
    {
        return $this->annonces_tags;
    }

    public function addAnnoncesTag(Annonce $annoncesTag): self
    {
        if (!$this->annonces_tags->contains($annoncesTag)) {
            $this->annonces_tags[] = $annoncesTag;
            $annoncesTag->addTag($this);
        }

        return $this;
    }

    public function removeAnnoncesTag(Annonce $annoncesTag): self
    {
        if ($this->annonces_tags->removeElement($annoncesTag)) {
            $annoncesTag->removeTag($this);
        }

        return $this;
    }
}
