<?php

namespace App\Entity\Newsletter;

use App\Entity\Dictionnaire;
use App\Entity\ResourceId;
use App\Entity\Timestapable;
use App\Repository\Newsletter\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UsersRepository::class)
 */
class Users
{
    use ResourceId;
    use Timestapable;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, unique=true)
     */
    private ?string $email;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $is_rgpd = false;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $validation_token;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $is_valid = false;

    /**
     * @ORM\ManyToMany(targetEntity=Dictionnaire::class, inversedBy="users_newsletter")
     */
    private Collection $categorie;


    public function __construct()
    {
        $this->setCreatedAt(new \DateTimeImmutable('now'));
        $this->categorie = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getIsRgpd(): ?bool
    {
        return $this->is_rgpd;
    }

    public function setIsRgpd(bool $is_rgpd): self
    {
        $this->is_rgpd = $is_rgpd;

        return $this;
    }

    public function getValidationToken(): ?string
    {
        return $this->validation_token;
    }

    public function setValidationToken(string $validation_token): self
    {
        $this->validation_token = $validation_token;

        return $this;
    }

    public function getIsValid(): ?bool
    {
        return $this->is_valid;
    }

    public function setIsValid(bool $is_valid): self
    {
        $this->is_valid = $is_valid;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getCategorie(): Collection
    {
        return $this->categorie;
    }

    public function addCategorie(Dictionnaire $categorie): self
    {
        if (!$this->categorie->contains($categorie)) {
            $this->categorie[] = $categorie;
            $categorie->addUsersNewsletter($this);
        }

        return $this;
    }

    public function removeCategorie(Dictionnaire $categorie): self
    {
        if ($this->categorie->removeElement($categorie)) {
            $categorie->removeUsersNewsletter($this);
        }

        return $this;
    }
}