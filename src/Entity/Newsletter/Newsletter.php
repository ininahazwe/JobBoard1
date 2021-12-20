<?php

namespace App\Entity\Newsletter;

use App\Entity\ResourceId;
use App\Entity\Dictionnaire;
use App\Entity\Timestapable;
use App\Repository\Newsletter\NewsletterRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NewsletterRepository::class)
 * @ORM\Table(name="newsletters")
 */
class Newsletter
{
    use ResourceId;
    use Timestapable;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $name;

    /**
     * @ORM\Column(type="text")
     */
    private ?string $content;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $is_sent = false;

    /**
     * @ORM\ManyToOne(targetEntity=Dictionnaire::class, inversedBy="newsletter_categorie")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Dictionnaire $categorie;

    public function __construct()
    {
        $this->setCreatedAt(new \DateTimeImmutable('now'));
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getIsSent(): ?bool
    {
        return $this->is_sent;
    }

    public function setIsSent(bool $is_sent): self
    {
        $this->is_sent = $is_sent;

        return $this;
    }

    public function getCategorie(): ?Dictionnaire
    {
        return $this->categorie;
    }

    public function setCategorie(?Dictionnaire $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }
}