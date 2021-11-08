<?php

namespace App\Entity;

use App\Repository\PavillonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=PavillonRepository::class)
 */
class Pavillon
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
     * @ORM\ManyToOne(targetEntity=Dictionnaire::class, inversedBy="pavillons")
     */
    private ?Dictionnaire $type;

    /**
     * @ORM\ManyToMany(targetEntity=Forum::class, mappedBy="pavillon")
     */
    private Collection $forums;

    public function __construct()
    {
        $this->forums = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable('now');
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
    public function getForums(): Collection
    {
        return $this->forums;
    }

    public function addForum(Forum $forum): self
    {
        if (!$this->forums->contains($forum)) {
            $this->forums[] = $forum;
            $forum->addPavillon($this);
        }

        return $this;
    }

    public function removeForum(Forum $forum): self
    {
        if ($this->forums->removeElement($forum)) {
            $forum->removePavillon($this);
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->nom;
    }
}
