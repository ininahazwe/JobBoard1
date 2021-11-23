<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    const EN_ATTENTE = 0;
    const ACCEPTEE = 1;
    const REFUSEE = 2;

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
     * @ORM\OneToMany(targetEntity=File::class, mappedBy="user", cascade={"persist"})
     */
    private Collection $files;

    /**
     * @ORM\ManyToMany(targetEntity=Blog::class, mappedBy="auteur")
     */
    private Collection $blogs;

    /**
     * @ORM\ManyToMany(targetEntity=Annonce::class, mappedBy="favoris")
     */
    private Collection $favoris;

    /**
     * @ORM\ManyToMany(targetEntity=Stand::class, mappedBy="favoris_stand")
     */
    private Collection $stands_favoris;

    /**
     * @ORM\ManyToMany(targetEntity=Stand::class, mappedBy="gestionnaire")
     */
    private Collection $stand_gestionnaires;

    /**
     * @ORM\OneToMany(targetEntity=Speedmeeting::class, mappedBy="gestionnaire")
     */
    private Collection $speedmeeting_gestionnaire;

    /**
     * @ORM\OneToMany(targetEntity=Candidature::class, mappedBy="recruteur")
     */
    private Collection $candidature_recruteur;

    /**
     * @ORM\OneToMany(targetEntity=Annonce::class, mappedBy="recruteur")
     */
    private Collection $annonce_recruteur;

    public function __construct()
    {
        $this->setCreatedAt(new \DateTimeImmutable('now'));
        $this->files = new ArrayCollection();
        $this->blogs = new ArrayCollection();
        $this->favoris = new ArrayCollection();
        $this->stands_favoris = new ArrayCollection();
        $this->stand_gestionnaires = new ArrayCollection();
        $this->speedmeeting_gestionnaire = new ArrayCollection();
        $this->candidature_recruteur = new ArrayCollection();
        $this->annonce_recruteur = new ArrayCollection();
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

    public function getStandsAll(): ArrayCollection
    {

        $stands= new ArrayCollection();
        foreach($this->getStandGestionnaires() as $stand){
            if (!$stands->contains($stand)){
                $stands->add($stand);
            }
        }
        foreach($this->getStands() as $stand){
            if (!$stands->contains($stand)){
                $stands->add($stand);
            }
        }
        return $stands;
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

    /**
     * @return Collection
     */
    public function getFiles(): Collection
    {
        return $this->files;
    }

    public function addFile(File $file): self
    {
        if (!$this->files->contains($file)) {
            $this->files[] = $file;
            $file->setUser($this);
        }

        return $this;
    }

    public function removeFile(File $file): self
    {
        if ($this->files->removeElement($file)) {
            // set the owning side to null (unless already changed)
            if ($file->getUser() === $this) {
                $file->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getFullname();
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
            $blog->addAuteur($this);
        }

        return $this;
    }

    public function removeBlog(Blog $blog): self
    {
        if ($this->blogs->removeElement($blog)) {
            $blog->removeAuteur($this);
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getFavoris(): Collection
    {
        return $this->favoris;
    }

    public function addFavori(Annonce $favori): self
    {
        if (!$this->favoris->contains($favori)) {
            $this->favoris[] = $favori;
            $favori->addFavori($this);
        }

        return $this;
    }

    public function removeFavori(Annonce $favori): self
    {
        if ($this->favoris->removeElement($favori)) {
            $favori->removeFavori($this);
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getStandsFavoris(): Collection
    {
        return $this->stands_favoris;
    }

    public function addStandsFavori(Stand $standsFavori): self
    {
        if (!$this->stands_favoris->contains($standsFavori)) {
            $this->stands_favoris[] = $standsFavori;
            $standsFavori->addFavorisStand($this);
        }

        return $this;
    }

    public function removeStandsFavori(Stand $standsFavori): self
    {
        if ($this->stands_favoris->removeElement($standsFavori)) {
            $standsFavori->removeFavorisStand($this);
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getStandGestionnaires(): Collection
    {
        return $this->stand_gestionnaires;
    }

    public function addStandGestionnaire(Stand $standGestionnaire): self
    {
        if (!$this->stand_gestionnaires->contains($standGestionnaire)) {
            $this->stand_gestionnaires[] = $standGestionnaire;
            $standGestionnaire->addGestionnaire($this);
        }

        return $this;
    }

    public function removeStandGestionnaire(Stand $standGestionnaire): self
    {
        if ($this->stand_gestionnaires->removeElement($standGestionnaire)) {
            $standGestionnaire->removeGestionnaire($this);
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getSpeedmeetingGestionnaire(): Collection
    {
        return $this->speedmeeting_gestionnaire;
    }

    public function addSpeedmeetingGestionnaire(Speedmeeting $speedmeetingGestionnaire): self
    {
        if (!$this->speedmeeting_gestionnaire->contains($speedmeetingGestionnaire)) {
            $this->speedmeeting_gestionnaire[] = $speedmeetingGestionnaire;
            $speedmeetingGestionnaire->setGestionnaire($this);
        }

        return $this;
    }

    public function removeSpeedmeetingGestionnaire(Speedmeeting $speedmeetingGestionnaire): self
    {
        if ($this->speedmeeting_gestionnaire->removeElement($speedmeetingGestionnaire)) {
            // set the owning side to null (unless already changed)
            if ($speedmeetingGestionnaire->getGestionnaire() === $this) {
                $speedmeetingGestionnaire->setGestionnaire(null);
            }
        }

        return $this;
    }

     /**
     * @return Collection
     */
    public function getCandidatureRecruteur(): Collection
    {
        return $this->candidature_recruteur;
    }

    public function addCandidatureRecruteur(Candidature $candidatureRecruteur): self
    {
        if (!$this->candidature_recruteur->contains($candidatureRecruteur)) {
            $this->candidature_recruteur[] = $candidatureRecruteur;
            $candidatureRecruteur->setRecruteur($this);
        }

        return $this;
    }

    public function removeCandidatureRecruteur(Candidature $candidatureRecruteur): self
    {
        if ($this->candidature_recruteur->removeElement($candidatureRecruteur)) {
            // set the owning side to null (unless already changed)
            if ($candidatureRecruteur->getRecruteur() === $this) {
                $candidatureRecruteur->setRecruteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getAnnonceRecruteur(): Collection
    {
        return $this->annonce_recruteur;
    }

    public function addAnnonceRecruteur(Annonce $annonceRecruteur): self
    {
        if (!$this->annonce_recruteur->contains($annonceRecruteur)) {
            $this->annonce_recruteur[] = $annonceRecruteur;
            $annonceRecruteur->setRecruteur($this);
        }

        return $this;
    }

    public function removeAnnonceRecruteur(Annonce $annonceRecruteur): self
    {
        if ($this->annonce_recruteur->removeElement($annonceRecruteur)) {
            // set the owning side to null (unless already changed)
            if ($annonceRecruteur->getRecruteur() === $this) {
                $annonceRecruteur->setRecruteur(null);
            }
        }

        return $this;
    }

}
