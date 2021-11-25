<?php

namespace App\Entity;

use App\Repository\DictionnaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DictionnaireRepository::class)
 */
class Dictionnaire {

    use ResourceId;
    use Timestapable;

    const TYPE_CONTRAT = 'contrat';
    const TYPE_DIPLOMA = 'diploma';
    const TYPE_EXPERIENCE = 'experience';
    const TYPE_LANGUAGE = 'langues';
    const TYPE_LEVEL = 'niveau';
    const TYPE_CONTRAT_FORMATION = 'Contrat_formation';
    const TYPE_SOURCE = 'source';
    const TYPE_START = 'debut';
    const TYPE_BUDGET = 'budget';
    const TYPE_SECTEUR = 'secteur';
    const TYPE_DURATION = 'duree';
    const TYPE_REFUS = 'refus';
    const TYPE_METIER = 'metier';
    const TYPE_MOBILIER = 'mobilier';
    const TYPE_PLANTE = 'plante';
    const TYPE_TRANSPORT = 'transport';
    const TYPE_ENTRETIEN = 'entretien';
    const TYPE_FORMATION = 'formation';
    const TYPE_CATEGORIE_ANNUAIRE = 'annuaire';
    const TYPE_CATEGORIE_AGENDA = 'agenda';
    const TYPE_CATEGORIE_BLOG = 'blog';
    const TYPE_CATEGORIE_CIVILITE = 'civilite';
    const TYPE_ZONE_GEOGRAPHIQUE = 'zone_geographique';
    const TYPE_FORUM_OPENING_STATUS = 'opening_status';
    const TYPE_PAVILLON = 'type_pavillon';
    const TYPE_STAND = 'type_stand';
    const TYPE_FAQ_BLOG = 'type_faq_blog';
    const TYPE_BLOG = 'type_blog';
    const TYPE_QUESTION = 'type_question';
    const TYPE_ANNUAIRE = 'type_annuaire';
    const TYPE_DUREE_ECHANGE_SPEEDMEETING = 'duree_echange_speedmeeting';

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $value;

    /**
     * @ORM\OneToMany(targetEntity=Profile::class, mappedBy="typeContrat")
     */
    private Collection $profilesContrat;

    /**
     * @ORM\OneToMany(targetEntity=Profile::class, mappedBy="secteurActivite")
     */
    private Collection $profilesSecteur;

    /**
     * @ORM\OneToMany(targetEntity=Profile::class, mappedBy="typeEntretien")
     */
    private Collection $profilesEntretien;

    /**
     * @ORM\OneToMany(targetEntity=Profile::class, mappedBy="typeDiplome")
     */
    private Collection $profilesDiplome;

    /**
     * @ORM\OneToMany(targetEntity=Profile::class, mappedBy="langues")
     */
    private Collection $profilesLangues;

    /**
     * @ORM\OneToMany(targetEntity=Profile::class, mappedBy="niveau")
     */
    private Collection $profilesNiveau;

    /**
     * @ORM\OneToMany(targetEntity=Profile::class, mappedBy="zonegeographique")
     */
    private Collection $profilesZoneGeographique;

    /**
     * @ORM\OneToMany(targetEntity=Forum::class, mappedBy="opening_statut")
     */
    private Collection $forumsOpeningStatus;

    /**
     * @ORM\OneToMany(targetEntity=Pavillon::class, mappedBy="type")
     */
    private Collection $pavillons;

    /**
     * @ORM\OneToMany(targetEntity=Stand::class, mappedBy="type")
     */
    private Collection $stands;

    /**
     * @ORM\OneToMany(targetEntity=Profile::class, mappedBy="experiences")
     */
    private $dureeExperiences;

    /**
     * @ORM\OneToMany(targetEntity=Blog::class, mappedBy="type")
     */
    private Collection $blogs;

    /**
     * @ORM\OneToMany(targetEntity=Blog::class, mappedBy="faq")
     */
    private Collection $blog_faq;

    /**
     * @ORM\OneToMany(targetEntity=Annonce::class, mappedBy="diplome")
     */
    private Collection $annonces_diplome;

    /**
     * @ORM\OneToMany(targetEntity=Annonce::class, mappedBy="experience")
     */
    private Collection $annonces_experience;

    /**
     * @ORM\OneToMany(targetEntity=Annonce::class, mappedBy="contrat")
     */
    private Collection $annonces_contrat;

    /**
     * @ORM\ManyToMany(targetEntity=Annonce::class, mappedBy="zone")
     */
    private Collection $annonces_zone;

    /**
     * @ORM\ManyToMany(targetEntity=Annonce::class, mappedBy="secteur")
     */
    private Collection $annonces_secteur;

    /**
     * @ORM\OneToMany(targetEntity=Question::class, mappedBy="type")
     */
    private Collection $questions;

    /**
     * @ORM\OneToMany(targetEntity=Annuaire::class, mappedBy="type")
     */
    private Collection $annuaires_type;

    /**
     * @ORM\ManyToMany(targetEntity=Annuaire::class, mappedBy="contrat")
     */
    private Collection $annuaires_contrat;

    /**
     * @ORM\ManyToMany(targetEntity=Annuaire::class, mappedBy="zone")
     */
    private Collection $annuaires_zone;

    /**
     * @ORM\ManyToMany(targetEntity=Annuaire::class, mappedBy="secteur")
     */
    private Collection $annuaires_secteur;

    /**
     * @ORM\ManyToMany(targetEntity=Annuaire::class, mappedBy="diplome")
     */
    private Collection $annuaires_diplome;

    /**
     * @ORM\OneToMany(targetEntity=Speedmeeting::class, mappedBy="diplome")
     */
    private Collection $speedmeeting_diplome;

    /**
     * @ORM\OneToMany(targetEntity=Speedmeeting::class, mappedBy="contrat")
     */
    private Collection $speedmeeting_contrat;

    /**
     * @ORM\ManyToMany(targetEntity=Speedmeeting::class, mappedBy="zone")
     */
    private Collection $speedmeeting_zone;

    /**
     * @ORM\ManyToMany(targetEntity=Speedmeeting::class, mappedBy="secteur")
     */
    private Collection $speedmeeting_secteur;

    /**
     * @ORM\OneToMany(targetEntity=Speedmeeting::class, mappedBy="duree_echange")
     */
    private Collection $speedmeeting_dure_echange;

    public function __construct() {
        $this->setCreatedAt(new \DateTimeImmutable('now'));
        $this->profilesContrat = new ArrayCollection();
        $this->profilesSecteur = new ArrayCollection();
        $this->profilesEntretien = new ArrayCollection();
        $this->profilesDiplome = new ArrayCollection();
        $this->profilesLangues = new ArrayCollection();
        $this->profilesNiveau = new ArrayCollection();
        $this->profilesZoneGeographique = new ArrayCollection();
        $this->forumsOpeningStatus = new ArrayCollection();
        $this->pavillons = new ArrayCollection();
        $this->stands = new ArrayCollection();
        $this->dureeExperiences = new ArrayCollection();
        $this->blogs = new ArrayCollection();
        $this->blog_faq = new ArrayCollection();
        $this->annonces_diplome = new ArrayCollection();
        $this->annonces_experience = new ArrayCollection();
        $this->annonces_contrat = new ArrayCollection();
        $this->annonces_zone = new ArrayCollection();
        $this->annonces_secteur = new ArrayCollection();
        $this->questions = new ArrayCollection();
        $this->annuaires_type = new ArrayCollection();
        $this->annuaires_contrat = new ArrayCollection();
        $this->annuaires_zone = new ArrayCollection();
        $this->annuaires_secteur = new ArrayCollection();
        $this->annuaires_diplome = new ArrayCollection();
        $this->speedmeeting_diplome = new ArrayCollection();
        $this->speedmeeting_contrat = new ArrayCollection();
        $this->speedmeeting_zone = new ArrayCollection();
        $this->speedmeeting_secteur = new ArrayCollection();
        $this->speedmeeting_dure_echange = new ArrayCollection();
    }

    public static function getTypeList(): array {
        return array(
                'Contrat' => Dictionnaire::TYPE_CONTRAT,
                'Diplôme' => Dictionnaire::TYPE_DIPLOMA,
                'Expérience' => Dictionnaire::TYPE_EXPERIENCE,
                'Langues' => Dictionnaire::TYPE_LANGUAGE,
                'Niveau' => Dictionnaire::TYPE_LEVEL,
                'Contrat de formation' => Dictionnaire::TYPE_CONTRAT_FORMATION,
                'Source' => Dictionnaire::TYPE_SOURCE,
                'Début' => Dictionnaire::TYPE_START,
                'Budget' => Dictionnaire::TYPE_BUDGET,
                'Secteur' => Dictionnaire::TYPE_SECTEUR,
                'Durée' => Dictionnaire::TYPE_DURATION,
                'Refus' => Dictionnaire::TYPE_REFUS,
                'Catégorie métier' => Dictionnaire::TYPE_METIER,
                'Mobilier' => Dictionnaire::TYPE_MOBILIER,
                'Plante' => Dictionnaire::TYPE_PLANTE,
                'Transport' => Dictionnaire::TYPE_TRANSPORT,
                'Entretien' => Dictionnaire::TYPE_ENTRETIEN,
                'Formation' => Dictionnaire::TYPE_FORMATION,
                'Catégorie annuaire' => Dictionnaire::TYPE_CATEGORIE_ANNUAIRE,
                'Catégorie agenda' => Dictionnaire::TYPE_CATEGORIE_AGENDA,
                'Catégorie blog' => Dictionnaire::TYPE_CATEGORIE_BLOG,
                'Civilité' => Dictionnaire::TYPE_CATEGORIE_CIVILITE,
                'Zone géographique' => Dictionnaire::TYPE_ZONE_GEOGRAPHIQUE,
                'Statut ouverture forum' => Dictionnaire::TYPE_FORUM_OPENING_STATUS,
                'Type de pavillon' => Dictionnaire::TYPE_PAVILLON,
                'Type de stand' => Dictionnaire::TYPE_STAND,
                'Type de FaQ Blog' => Dictionnaire::TYPE_FAQ_BLOG,
                'Type de blog' => Dictionnaire::TYPE_BLOG,
                'Type de question' => Dictionnaire::TYPE_QUESTION,
                'Type d\'annuaire' => Dictionnaire::TYPE_ANNUAIRE,
                'Durée Echange Speedmeeting' => Dictionnaire::TYPE_DUREE_ECHANGE_SPEEDMEETING,
        );
    }

    public function getType(): ?string {
        return $this->type;
    }

    public function setType(string $type): self {
        $this->type = $type;

        return $this;
    }

    public function getValue(): ?string {
        return $this->value;
    }

    public function setValue(string $value): self {
        $this->value = $value;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getProfilesContrat(): Collection {
        return $this->profilesContrat;
    }

    public function addProfileContrat(Profile $profile): self {
        if (!$this->profilesContrat->contains($profile)) {
            $this->profilesContrat[] = $profile;
            $profile->setTypeContrat($this);
        }

        return $this;
    }

    public function removeProfileContrat(Profile $profile): self {
        if ($this->profilesContrat->removeElement($profile)) {
            // set the owning side to null (unless already changed)
            if ($profile->getTypeContrat() === $this) {
                $profile->setTypeContrat(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getProfilesSecteur(): Collection {
        return $this->profilesSecteur;
    }

    public function addProfileSecteur(Profile $profile): self {
        if (!$this->profilesSecteur->contains($profile)) {
            $this->profilesSecteur[] = $profile;
            $profile->setSecteurActivite($this);
        }

        return $this;
    }

    public function removeProfileSecteur(Profile $profile): self {
        if ($this->profilesSecteur->removeElement($profile)) {
            // set the owning side to null (unless already changed)
            if ($profile->getSecteurActivite() === $this) {
                $profile->setSecteurActivite(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getProfilesEntretien(): Collection {
        return $this->profilesEntretien;
    }

    public function addProfileEntretien(Profile $profile): self {
        if (!$this->profilesEntretien->contains($profile)) {
            $this->profilesEntretien[] = $profile;
            $profile->setTypeEntretien($this);
        }

        return $this;
    }

    public function removeProfileEntretien(Profile $profile): self {
        if ($this->profilesEntretien->removeElement($profile)) {
            // set the owning side to null (unless already changed)
            if ($profile->getTypeEntretien() === $this) {
                $profile->setTypeEntretien(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getProfilesDiplome(): Collection {
        return $this->profilesDiplome;
    }

    public function addProfilesDiplome(Profile $profilesDiplome): self {
        if (!$this->profilesDiplome->contains($profilesDiplome)) {
            $this->profilesDiplome[] = $profilesDiplome;
            $profilesDiplome->setTypeDiplome($this);
        }

        return $this;
    }

    public function removeProfilesDiplome(Profile $profilesDiplome): self {
        if ($this->profilesDiplome->removeElement($profilesDiplome)) {
            // set the owning side to null (unless already changed)
            if ($profilesDiplome->getTypeDiplome() === $this) {
                $profilesDiplome->setTypeDiplome(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getProfilesLangues(): Collection {
        return $this->profilesLangues;
    }

    public function addProfilesLangue(Profile $profilesLangue): self {
        if (!$this->profilesLangues->contains($profilesLangue)) {
            $this->profilesLangues[] = $profilesLangue;
            $profilesLangue->setLangues($this);
        }

        return $this;
    }

    public function removeProfilesLangue(Profile $profilesLangue): self {
        if ($this->profilesLangues->removeElement($profilesLangue)) {
            // set the owning side to null (unless already changed)
            if ($profilesLangue->getLangues() === $this) {
                $profilesLangue->setLangues(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getProfilesNiveau(): Collection {
        return $this->profilesNiveau;
    }

    public function addProfilesNiveau(Profile $profilesNiveau): self {
        if (!$this->profilesNiveau->contains($profilesNiveau)) {
            $this->profilesNiveau[] = $profilesNiveau;
            $profilesNiveau->setNiveau($this);
        }

        return $this;
    }

    public function removeProfilesNiveau(Profile $profilesNiveau): self {
        if ($this->profilesNiveau->removeElement($profilesNiveau)) {
            // set the owning side to null (unless already changed)
            if ($profilesNiveau->getNiveau() === $this) {
                $profilesNiveau->setNiveau(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getProfilesZoneGeographique(): Collection {
        return $this->profilesZoneGeographique;
    }

    public function addProfilesZoneGeographique(Profile $profilesZoneGeographique): self {
        if (!$this->profilesZoneGeographique->contains($profilesZoneGeographique)) {
            $this->profilesZoneGeographique[] = $profilesZoneGeographique;
            $profilesZoneGeographique->setZonegeographique($this);
        }

        return $this;
    }

    public function removeProfilesZoneGeographique(Profile $profilesZoneGeographique): self {
        if ($this->profilesZoneGeographique->removeElement($profilesZoneGeographique)) {
            // set the owning side to null (unless already changed)
            if ($profilesZoneGeographique->getZonegeographique() === $this) {
                $profilesZoneGeographique->setZonegeographique(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getForumsOpeningStatus(): Collection {
        return $this->forumsOpeningStatus;
    }

    public function addForumsOpeningStatus(Forum $forumsOpeningStatus): self {
        if (!$this->forumsOpeningStatus->contains($forumsOpeningStatus)) {
            $this->forumsOpeningStatus[] = $forumsOpeningStatus;
            $forumsOpeningStatus->setOpeningStatut($this);
        }

        return $this;
    }

    public function removeForumsOpeningStatus(Forum $forumsOpeningStatus): self {
        if ($this->forumsOpeningStatus->removeElement($forumsOpeningStatus)) {
            // set the owning side to null (unless already changed)
            if ($forumsOpeningStatus->getOpeningStatut() === $this) {
                $forumsOpeningStatus->setOpeningStatut(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getPavillons(): Collection {
        return $this->pavillons;
    }

    public function addPavillon(Pavillon $pavillon): self {
        if (!$this->pavillons->contains($pavillon)) {
            $this->pavillons[] = $pavillon;
            $pavillon->setType($this);
        }

        return $this;
    }

    public function removePavillon(Pavillon $pavillon): self {
        if ($this->pavillons->removeElement($pavillon)) {
            // set the owning side to null (unless already changed)
            if ($pavillon->getType() === $this) {
                $pavillon->setType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getStands(): Collection
    {
        return $this->stands;
    }

    public function addStand(Stand $stand): self
    {
        if (!$this->stands->contains($stand)) {
            $this->stands[] = $stand;
            $stand->setType($this);
        }

        return $this;
    }

    public function removeStand(Stand $stand): self
    {
        if ($this->stands->removeElement($stand)) {
            // set the owning side to null (unless already changed)
            if ($stand->getType() === $this) {
                $stand->setType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getDureeExperiences(): Collection
    {
        return $this->dureeExperiences;
    }

    public function addDureeExperience(Profile $dureeExperience): self
    {
        if (!$this->dureeExperiences->contains($dureeExperience)) {
            $this->dureeExperiences[] = $dureeExperience;
            $dureeExperience->setExperiences($this);
        }

        return $this;
    }

    public function removeDureeExperience(Profile $dureeExperience): self
    {
        if ($this->dureeExperiences->removeElement($dureeExperience)) {
            // set the owning side to null (unless already changed)
            if ($dureeExperience->getExperiences() === $this) {
                $dureeExperience->setExperiences(null);
            }
        }

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
            $blog->setType($this);
        }

        return $this;
    }

    public function removeBlog(Blog $blog): self
    {
        if ($this->blogs->removeElement($blog)) {
            // set the owning side to null (unless already changed)
            if ($blog->getType() === $this) {
                $blog->setType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getBlogFaq(): Collection
    {
        return $this->blog_faq;
    }

    public function addBlogFaq(Blog $blogFaq): self
    {
        if (!$this->blog_faq->contains($blogFaq)) {
            $this->blog_faq[] = $blogFaq;
            $blogFaq->setFaq($this);
        }

        return $this;
    }

    public function removeBlogFaq(Blog $blogFaq): self
    {
        if ($this->blog_faq->removeElement($blogFaq)) {
            // set the owning side to null (unless already changed)
            if ($blogFaq->getFaq() === $this) {
                $blogFaq->setFaq(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getAnnoncesDiplome(): Collection
    {
        return $this->annonces_diplome;
    }

    public function addAnnoncesDiplome(Annonce $annoncesDiplome): self
    {
        if (!$this->annonces_diplome->contains($annoncesDiplome)) {
            $this->annonces_diplome[] = $annoncesDiplome;
            $annoncesDiplome->setDiplome($this);
        }

        return $this;
    }

    public function removeAnnoncesDiplome(Annonce $annoncesDiplome): self
    {
        if ($this->annonces_diplome->removeElement($annoncesDiplome)) {
            // set the owning side to null (unless already changed)
            if ($annoncesDiplome->getDiplome() === $this) {
                $annoncesDiplome->setDiplome(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getAnnoncesExperience(): Collection
    {
        return $this->annonces_experience;
    }

    public function addAnnoncesExperience(Annonce $annoncesExperience): self
    {
        if (!$this->annonces_experience->contains($annoncesExperience)) {
            $this->annonces_experience[] = $annoncesExperience;
            $annoncesExperience->setExperience($this);
        }

        return $this;
    }

    public function removeAnnoncesExperience(Annonce $annoncesExperience): self
    {
        if ($this->annonces_experience->removeElement($annoncesExperience)) {
            // set the owning side to null (unless already changed)
            if ($annoncesExperience->getExperience() === $this) {
                $annoncesExperience->setExperience(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getAnnoncesContrat(): Collection
    {
        return $this->annonces_contrat;
    }

    public function addAnnoncesContrat(Annonce $annoncesContrat): self
    {
        if (!$this->annonces_contrat->contains($annoncesContrat)) {
            $this->annonces_contrat[] = $annoncesContrat;
            $annoncesContrat->setContrat($this);
        }

        return $this;
    }

    public function removeAnnoncesContrat(Annonce $annoncesContrat): self
    {
        if ($this->annonces_contrat->removeElement($annoncesContrat)) {
            // set the owning side to null (unless already changed)
            if ($annoncesContrat->getContrat() === $this) {
                $annoncesContrat->setContrat(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getAnnoncesZone(): Collection
    {
        return $this->annonces_zone;
    }

    public function addAnnoncesZone(Annonce $annoncesZone): self
    {
        if (!$this->annonces_zone->contains($annoncesZone)) {
            $this->annonces_zone[] = $annoncesZone;
            $annoncesZone->addZone($this);
        }

        return $this;
    }

    public function removeAnnoncesZone(Annonce $annoncesZone): self
    {
        if ($this->annonces_zone->removeElement($annoncesZone)) {
            $annoncesZone->removeZone($this);
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getAnnoncesSecteur(): Collection
    {
        return $this->annonces_secteur;
    }

    public function addAnnoncesSecteur(Annonce $annoncesSecteur): self
    {
        if (!$this->annonces_secteur->contains($annoncesSecteur)) {
            $this->annonces_secteur[] = $annoncesSecteur;
            $annoncesSecteur->addSecteur($this);
        }

        return $this;
    }

    public function removeAnnoncesSecteur(Annonce $annoncesSecteur): self
    {
        if ($this->annonces_secteur->removeElement($annoncesSecteur)) {
            $annoncesSecteur->removeSecteur($this);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function __toString(): string {
        return $this->value;
    }

    /**
     * @return Collection
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions[] = $question;
            $question->setType($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        if ($this->questions->removeElement($question)) {
            // set the owning side to null (unless already changed)
            if ($question->getType() === $this) {
                $question->setType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getAnnuaires(): Collection
    {
        return $this->annuaires_type;
    }

    public function addAnnuaire(Annuaire $annuaire): self
    {
        if (!$this->annuaires_type->contains($annuaire)) {
            $this->annuaires_type[] = $annuaire;
            $annuaire->setType($this);
        }

        return $this;
    }

    public function removeAnnuaire(Annuaire $annuaire): self
    {
        if ($this->annuaires_type->removeElement($annuaire)) {
            // set the owning side to null (unless already changed)
            if ($annuaire->getType() === $this) {
                $annuaire->setType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getAnnuairesContrat(): Collection
    {
        return $this->annuaires_contrat;
    }

    public function addAnnuairesContrat(Annuaire $annuairesContrat): self
    {
        if (!$this->annuaires_contrat->contains($annuairesContrat)) {
            $this->annuaires_contrat[] = $annuairesContrat;
            $annuairesContrat->addContrat($this);
        }

        return $this;
    }

    public function removeAnnuairesContrat(Annuaire $annuairesContrat): self
    {
        if ($this->annuaires_contrat->removeElement($annuairesContrat)) {
            $annuairesContrat->removeContrat($this);
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getAnnuairesZone(): Collection
    {
        return $this->annuaires_zone;
    }

    public function addAnnuairesZone(Annuaire $annuairesZone): self
    {
        if (!$this->annuaires_zone->contains($annuairesZone)) {
            $this->annuaires_zone[] = $annuairesZone;
            $annuairesZone->addZone($this);
        }

        return $this;
    }

    public function removeAnnuairesZone(Annuaire $annuairesZone): self
    {
        if ($this->annuaires_zone->removeElement($annuairesZone)) {
            $annuairesZone->removeZone($this);
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getAnnuairesSecteur(): Collection
    {
        return $this->annuaires_secteur;
    }

    public function addAnnuairesSecteur(Annuaire $annuairesSecteur): self
    {
        if (!$this->annuaires_secteur->contains($annuairesSecteur)) {
            $this->annuaires_secteur[] = $annuairesSecteur;
            $annuairesSecteur->addSecteur($this);
        }

        return $this;
    }

    public function removeAnnuairesSecteur(Annuaire $annuairesSecteur): self
    {
        if ($this->annuaires_secteur->removeElement($annuairesSecteur)) {
            $annuairesSecteur->removeSecteur($this);
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getAnnuairesDiplome(): Collection
    {
        return $this->annuaires_diplome;
    }

    public function addAnnuairesDiplome(Annuaire $annuairesDiplome): self
    {
        if (!$this->annuaires_diplome->contains($annuairesDiplome)) {
            $this->annuaires_diplome[] = $annuairesDiplome;
            $annuairesDiplome->addDiplome($this);
        }

        return $this;
    }

    public function removeAnnuairesDiplome(Annuaire $annuairesDiplome): self
    {
        if ($this->annuaires_diplome->removeElement($annuairesDiplome)) {
            $annuairesDiplome->removeDiplome($this);
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getSpeedmeetingDiplome(): Collection
    {
        return $this->speedmeeting_diplome;
    }

    public function addSpeedmeetingDiplome(Speedmeeting $speedmeetingDiplome): self
    {
        if (!$this->speedmeeting_diplome->contains($speedmeetingDiplome)) {
            $this->speedmeeting_diplome[] = $speedmeetingDiplome;
            $speedmeetingDiplome->setDiplome($this);
        }

        return $this;
    }

    public function removeSpeedmeetingDiplome(Speedmeeting $speedmeetingDiplome): self
    {
        if ($this->speedmeeting_diplome->removeElement($speedmeetingDiplome)) {
            // set the owning side to null (unless already changed)
            if ($speedmeetingDiplome->getDiplome() === $this) {
                $speedmeetingDiplome->setDiplome(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getSpeedmeetingContrat(): Collection
    {
        return $this->speedmeeting_contrat;
    }

    public function addSpeedmeetingContrat(Speedmeeting $speedmeetingContrat): self
    {
        if (!$this->speedmeeting_contrat->contains($speedmeetingContrat)) {
            $this->speedmeeting_contrat[] = $speedmeetingContrat;
            $speedmeetingContrat->setContrat($this);
        }

        return $this;
    }

    public function removeSpeedmeetingContrat(Speedmeeting $speedmeetingContrat): self
    {
        if ($this->speedmeeting_contrat->removeElement($speedmeetingContrat)) {
            // set the owning side to null (unless already changed)
            if ($speedmeetingContrat->getContrat() === $this) {
                $speedmeetingContrat->setContrat(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getSpeedmeetingZone(): Collection
    {
        return $this->speedmeeting_zone;
    }

    public function addSpeedmeetingZone(Speedmeeting $speedmeetingZone): self
    {
        if (!$this->speedmeeting_zone->contains($speedmeetingZone)) {
            $this->speedmeeting_zone[] = $speedmeetingZone;
            $speedmeetingZone->addZone($this);
        }

        return $this;
    }

    public function removeSpeedmeetingZone(Speedmeeting $speedmeetingZone): self
    {
        if ($this->speedmeeting_zone->removeElement($speedmeetingZone)) {
            $speedmeetingZone->removeZone($this);
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getSpeedmeetingSecteur(): Collection
    {
        return $this->speedmeeting_secteur;
    }

    public function addSpeedmeetingSecteur(Speedmeeting $speedmeetingSecteur): self
    {
        if (!$this->speedmeeting_secteur->contains($speedmeetingSecteur)) {
            $this->speedmeeting_secteur[] = $speedmeetingSecteur;
            $speedmeetingSecteur->addSecteur($this);
        }

        return $this;
    }

    public function removeSpeedmeetingSecteur(Speedmeeting $speedmeetingSecteur): self
    {
        if ($this->speedmeeting_secteur->removeElement($speedmeetingSecteur)) {
            $speedmeetingSecteur->removeSecteur($this);
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getSpeedmeetingDureEchange(): Collection
    {
        return $this->speedmeeting_dure_echange;
    }

    public function addSpeedmeetingDureEchange(Speedmeeting $speedmeetingDureEchange): self
    {
        if (!$this->speedmeeting_dure_echange->contains($speedmeetingDureEchange)) {
            $this->speedmeeting_dure_echange[] = $speedmeetingDureEchange;
            $speedmeetingDureEchange->setDureeEchange($this);
        }

        return $this;
    }

    public function removeSpeedmeetingDureEchange(Speedmeeting $speedmeetingDureEchange): self
    {
        if ($this->speedmeeting_dure_echange->removeElement($speedmeetingDureEchange)) {
            // set the owning side to null (unless already changed)
            if ($speedmeetingDureEchange->getDureeEchange() === $this) {
                $speedmeetingDureEchange->setDureeEchange(null);
            }
        }

        return $this;
    }
}
