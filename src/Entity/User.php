<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    const GENRE_HOMME = 'Homme';
    const GENRE_FEMME = 'Femme';
    const GENRE_AUTRE = 'Autre';

    use ResourceId;
    use Timestapable;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private ?string $email;

    /**
     * @ORM\Column(type="json")
     */
    private array $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private string $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $civilite;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $prenom;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $isVerified = false;

    /**
     * @ORM\OneToOne(targetEntity=Profile::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private ?Profile $profile;

    /**
     * @ORM\OneToOne(targetEntity=CV::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $cV;

    public function __construct()
    {
        $this->setCreatedAt(new \DateTimeImmutable('now'));
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_CANDIDAT';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getCivilite(): ?string
    {
        return $this->civilite;
    }

    public function setCivilite(?string $civilite): self
    {
        $this->civilite = $civilite;

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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * @return string[]
     */
    public static function getGenreName(): array
    {
        return array(
                'Homme' => User::GENRE_HOMME,
                'Femme' => User::GENRE_FEMME,
                'Autre' => User::GENRE_AUTRE,
        );
    }

    /**
     * @return string
     */
    public function getFullname(): string
    {
        return $this->getPrenom().' '.$this->getNom();
    }

    public function checkRoles($role): bool
    {
        foreach($this->roles as $item)
        {
            if($item == $role)
            {
                return true;
            }
        }
        return false;
    }

    public function isCandidat(): bool
    {
        $role = "ROLE_CANDIDAT";
        return $this->checkRoles($role);
    }

    public function isRecruteur(): bool
    {
        $role = "ROLE_RECRUTEUR";
        return $this->checkRoles($role);
    }

    public function isSuperRecruteur(): bool
    {
        $role = "ROLE_SUPER_RECRUTEUR";
        return $this->checkRoles($role);
    }

    public function isCommunicant(): bool
    {
        $role = "ROLE_COMMUNICANT";
        return $this->checkRoles($role);
    }

    public function isSuperAdmin(): bool
    {
        $role = "ROLE_SUPER_ADMIN";
        return $this->checkRoles($role);
    }

    public function getRoleName():string
    {
        if ($this->isSuperAdmin()){
            return 'Super Administrateur';
        }else if($this->isSuperRecruteur()){
            return 'Super Recruteur';
        }else if($this->isRecruteur()){
            return 'Recruteur';
        }else if($this->isCandidat()){
            return 'Candidat';
        }else if($this->isCommunicant()){
            return 'Communicant';
        }else{
            return 'Non renseigné';
        }
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getFullname();
    }

    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    public function setProfile(Profile $profile): self
    {
        // set the owning side of the relation if necessary
        if ($profile->getUser() !== $this) {
            $profile->setUser($this);
        }

        $this->profile = $profile;

        return $this;
    }

    public function getCV(): ?CV
    {
        return $this->cV;
    }

    public function setCV(?CV $cV): self
    {
        // unset the owning side of the relation if necessary
        if ($cV === null && $this->cV !== null) {
            $this->cV->setUser(null);
        }

        // set the owning side of the relation if necessary
        if ($cV !== null && $cV->getUser() !== $this) {
            $cV->setUser($this);
        }

        $this->cV = $cV;

        return $this;
    }
}
