<?php

namespace App\Entity;

use App\Repository\FileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FileRepository::class)
 */
class File
{
    const TYPE_AVATAR = 1;
    const TYPE_CV = 2;
    const TYPE_MOTIVATION = 3;
    const TYPE_ILLUSTRATION = 4;
    const TYPE_LOGO = 5;
    const TYPE_DOCUMENTS = 6;

    use ResourceId;
    use Timestapable;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $nomFichier ="";

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $NomLibre ="";

    /**
     * @ORM\ManyToOne(targetEntity=Profile::class, inversedBy="photo")
     */
    private ?Profile $profile;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="files")
     */
    private ?User $user;

    /**
     * @ORM\ManyToOne(targetEntity=Profile::class, inversedBy="cv")
     */
    private ?Profile $cv_candidat;

    /**
     * @ORM\ManyToOne(targetEntity=Blog::class, inversedBy="images")
     */
    private ?Blog $blog;

    /**
     * @ORM\ManyToOne(targetEntity=CvExperience::class, inversedBy="documents")
     */
    private ?CvExperience $cvExperience;

    /**
     * @ORM\ManyToOne(targetEntity=Stand::class, inversedBy="logo")
     */
    private ?Stand $stand;

    /**
     * @ORM\ManyToOne(targetEntity=Forum::class, inversedBy="logo")
     */
    private ?Forum $forum;

    /**
     * @ORM\ManyToOne(targetEntity=Annonce::class, inversedBy="documents")
     */
    private ?Annonce $annonce;

    /**
     * @ORM\ManyToOne(targetEntity=Realisation::class, inversedBy="documents")
     */
    private ?Realisation $realisation;

    /**
     * @ORM\ManyToOne(targetEntity=Stand::class, inversedBy="documents")
     */
    private ?Stand  $stand_documents;

    /**
     * @ORM\ManyToOne(targetEntity=Candidature::class, inversedBy="lettre_motivation")
     */
    private ?Candidature $candidature_lettre_motivation;

    public function __construct() {
        $this->createdAt = new \DateTimeImmutable('now');
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getNomFichier(): ?string
    {
        return $this->nomFichier;
    }

    public function setNomFichier(string $nomFichier): self
    {
        $this->nomFichier = $nomFichier;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(?int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getNomLibre(): ?string
    {
        return $this->NomLibre;
    }

    public function setNomLibre(string $NomLibre): self
    {
        $this->NomLibre = $NomLibre;

        return $this;
    }

    /**
     * @return string
     */
    /*public function getTypeName(): string
    {
        $type = $this->type;
        if ($type == 1){
            return 'Avatar';
        }else if($type == 2){
            return 'CV';
        }else if($type == 3){
            return 'Lettre de motivation';
        }else if($type == 4){
            return 'Image d\'illustration';
        }else if($type == 5){
            return 'Logo';
        }else{
            return 'Non renseigné';
        }
    }*/

    /**
     * @return string
     */
    public static function getTypeName(): string
    {
        switch (true) {
            case 1 == File::TYPE_AVATAR;
                return 'Avatar';
            case 2 == File::TYPE_CV;
                return 'CV';
            case 3 == File::TYPE_MOTIVATION;
                return 'Lettre de motivation';
            case 4 == File::TYPE_ILLUSTRATION;
                return 'Image d\'illustration';
            case 5 == File::TYPE_LOGO;
                return 'Logo';
            default:
                return 'Non renseigné';
        }
    }

    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    public function setProfile(?Profile $profile): self
    {
        $this->profile = $profile;

        return $this;
    }

    public function __toString()
    {
        return $this->nomFichier;
    }

    public function getFileSize(): ?string
    {
        $file = 'uploads/' . $this->nom;

        $bytes = filesize($file);

        $label = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB' );
        for( $i = 0; $bytes >= 1024 && $i < ( count( $label ) -1 ); $bytes /= 1024, $i++ );
        return( round( $bytes, 0 ) . " " . $label[$i] );

    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCvCandidat(): ?Profile
    {
        return $this->cv_candidat;
    }

    public function setCvCandidat(?Profile $cv_candidat): self
    {
        $this->cv_candidat = $cv_candidat;

        return $this;
    }

    public function getBlog(): ?Blog
    {
        return $this->blog;
    }

    public function setBlog(?Blog $blog): self
    {
        $this->blog = $blog;

        return $this;
    }

    public function getCvExperience(): ?CvExperience
    {
        return $this->cvExperience;
    }

    public function setCvExperience(?CvExperience $cvExperience): self
    {
        $this->cvExperience = $cvExperience;

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

    public function getForum(): ?Forum
    {
        return $this->forum;
    }

    public function setForum(?Forum $forum): self
    {
        $this->forum = $forum;

        return $this;
    }

    public function getAnnonce(): ?Annonce
    {
        return $this->annonce;
    }

    public function setAnnonce(?Annonce $annonce): self
    {
        $this->annonce = $annonce;

        return $this;
    }

    public function getRealisation(): ?Realisation
    {
        return $this->realisation;
    }

    public function setRealisation(?Realisation $realisation): self
    {
        $this->realisation = $realisation;

        return $this;
    }

    public function getStandDocuments(): ?Stand
    {
        return $this->stand_documents;
    }

    public function setStandDocuments(?Stand $stand_documents): self
    {
        $this->stand_documents = $stand_documents;

        return $this;
    }

    public function getcandidatureLettreMotivation(): ?Candidature
    {
        return $this->candidature_lettre_motivation;
    }

    public function setcandidatureLettreMotivation(?Candidature $candidature_lettre_motivation): self
    {
        $this->candidature_lettre_motivation = $candidature_lettre_motivation;

        return $this;
    }
}
