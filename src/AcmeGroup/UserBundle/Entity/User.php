<?php
// src/AcmeGroup/UserBundle/Entity/User.php
 
namespace AcmeGroup\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="User")
 * @ORM\Entity(repositoryClass="AcmeGroup\UserBundle\Entity\UserRepository")
 */
class User extends BaseUser {

	private $modeslivraison;

	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

    /**
     * @var integer
     *
     * @ORM\OneToOne(targetEntity="AcmeGroup\LaboBundle\Entity\image", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true, unique=false)
     */
    private $avatar;

	/**
	* @ORM\Column(name="preferences", type="array", nullable=true)
	*/
	private $preferences;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="nom", type="string", length=50, nullable=true, unique=false)
	 * @Assert\NotBlank(message = "Vous devez préciser votre nom.")
	 * @Assert\Length(
	 *      min = "3",
	 *      max = "50",
	 *      minMessage = "Votre nom doit comporter au moins {{ limit }} lettres.",
	 *      maxMessage = "Votre nom peut comporter au maximum {{ limit }} lettres."
	 * )
	 */
	private $nom;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="prenom", type="string", length=100, nullable=true, unique=false)
	 * @Assert\Length(
	 *      min = "3",
	 *      max = "50",
	 *      minMessage = "Votre prénom doit comporter au moins {{ limit }} lettres.",
	 *      maxMessage = "Votre prénom peut comporter au maximum {{ limit }} lettres."
	 * )
	 */
	private $prenom;

    /**
     * @var integer
     *
     * @ORM\OneToOne(targetEntity="AcmeGroup\LaboBundle\Entity\adresse", mappedBy="user", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true, unique=false)
     */
	private $adresses;

    /**
     * @var integer
     *
     * @ORM\OneToOne(targetEntity="AcmeGroup\LaboBundle\Entity\telephone", mappedBy="user", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true, unique=false)
     */
	private $tels;

    /**
     * @var integer
     *
     * @ORM\OneToOne(targetEntity="AcmeGroup\LaboBundle\Entity\email", mappedBy="user", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true, unique=false)
     */
	private $otheremails;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="commentaire", type="text", nullable=true, unique=false)
	 */
	private $commentaire;

	/**
	* @var string
	*
	* @ORM\Column(name="adressIp", type="array", nullable=true)
	*/
	private $adressIps;

	/**
	 * @var array
	 *
	 * @ORM\OneToMany(targetEntity="AcmeGroup\LaboBundle\Entity\panier", mappedBy="user", cascade={"persist", "remove"})
	 * @ORM\JoinColumn(nullable=true)
	 */
	private $paniers;

	/**
	 * @var array
	 *
	 * @ORM\OneToMany(targetEntity="AcmeGroup\LaboBundle\Entity\image", mappedBy="user")
	 * @ORM\JoinColumn(nullable=true)
	 */
	private $images;

	/**
	 * @var array
	 *
	 * @ORM\OneToMany(targetEntity="AcmeGroup\LaboBundle\Entity\video", mappedBy="user")
	 * @ORM\JoinColumn(nullable=true)
	 */
	private $videos;

	/**
	 * @var array
	 *
	 * @ORM\OneToMany(targetEntity="AcmeGroup\LaboBundle\Entity\fiche", mappedBy="user")
	 * @ORM\JoinColumn(nullable=true)
	 */
	private $fiches;

	/**
	 * @var array
	 *
	 * @ORM\OneToMany(targetEntity="AcmeGroup\LaboBundle\Entity\article", mappedBy="user")
	 * @ORM\JoinColumn(nullable=true)
	 */
	private $articles;

	/**
	 * @var array
	 *
	 * @ORM\OneToMany(targetEntity="AcmeGroup\LaboBundle\Entity\evenement", mappedBy="user")
	 * @ORM\JoinColumn(nullable=true)
	 */
	private $evenements;

	/**
	 * @var array
	 *
	 * @ORM\OneToMany(targetEntity="AcmeGroup\LaboBundle\Entity\fichierPdf", mappedBy="user")
	 * @ORM\JoinColumn(nullable=true)
	 */
	private $fichierPdfs;

	/**
	 * @var array
	 *
	 * @ORM\OneToMany(targetEntity="AcmeGroup\LaboBundle\Entity\richtext", mappedBy="user")
	 * @ORM\JoinColumn(nullable=true)
	 */
	private $richtexts;

	/**
	 * @var array
	 *
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\LaboBundle\Entity\version", mappedBy="user")
	 * @ORM\JoinColumn(nullable=false, unique=false)
	 */
	protected $version;


	public function __construct() {
		parent::__construct();

		$this->images = new ArrayCollection();
		$this->paniers = new ArrayCollection();
		$this->videos = new ArrayCollection();
		$this->fiches = new ArrayCollection();
		$this->articles = new ArrayCollection();
		$this->evenements = new ArrayCollection();
		$this->fichierPdfs = new ArrayCollection();
		$this->richtexts = new ArrayCollection();
		$this->factures = new ArrayCollection();
		$this->adressIps = new ArrayCollection();
	}

	/**
	 * @Assert/True()
	 */
	public function isUserValid() {
		return true;
	}

	/**
	 * Get id
	 *
	 * @return integer 
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Add preference
	 *
	 * @param mixed $preference
	 * @return string
	 */
	public function addPreference($preference, $nom = null) {
		if($nom !== null) {
			$this->preferences[$nom] = $preference;
		} else {
			$this->preferences[] = $preference;
			$nom = key($this->preferences);
		}
		return $nom;
	}

	/**
	 * Remove preference
	 *
	 * @param mixed $preference
	 * @return boolean
	 */
	public function removePreference($preference) {
		return $this->preferences->removeElement($preference);
	}

	/**
	 * Remove preference by nom
	 *
	 * @param string $nom
	 * @return mixed
	 */
	public function removePreferenceByNom($nom) {
		return $this->preferences->remove($nom);
	}

	/**
	 * Get preferences
	 *
	 * @return ArrayCollection 
	 */
	public function getPreferences() {
		return $this->preferences;
	}

	/**
	 * Set adresse
	 *
	 * @param string $adresse
	 * @return User
	 */
	public function setAdresse($adresse) {
		$this->adresse = $adresse;
	
		return $this;
	}

	/**
	 * Get adresse
	 *
	 * @return string 
	 */
	public function getAdresse() {
		return $this->adresse;
	}

	/**
	 * Set nom
	 *
	 * @param string $nom
	 * @return User
	 */
	public function setNom($nom) {
		$this->nom = $nom;
	
		return $this;
	}

	/**
	 * Get nom
	 *
	 * @return string 
	 */
	public function getNom() {
		return $this->nom;
	}

	/**
	 * Set prenom
	 *
	 * @param string $prenom
	 * @return User
	 */
	public function setPrenom($prenom) {
		$this->prenom = $prenom;
	
		return $this;
	}

	/**
	 * Get prenom
	 *
	 * @return string 
	 */
	public function getPrenom() {
		return $this->prenom;
	}

	/**
	 * Set cp
	 *
	 * @param string $cp
	 * @return User
	 */
	public function setCp($cp) {
		$this->cp = $cp;
	
		return $this;
	}

	/**
	 * Get cp
	 *
	 * @return string 
	 */
	public function getCp() {
		return $this->cp;
	}

	/**
	 * Set ville
	 *
	 * @param string $ville
	 * @return User
	 */
	public function setVille($ville) {
		$this->ville = $ville;
	
		return $this;
	}

	/**
	 * Get ville
	 *
	 * @return string 
	 */
	public function getVille() {
		return $this->ville;
	}

	/**
	 * Set commentaire
	 *
	 * @param string $commentaire
	 * @return User
	 */
	public function setCommentaire($commentaire) {
		$this->commentaire = $commentaire;
	
		return $this;
	}

	/**
	 * Get commentaire
	 *
	 * @return string 
	 */
	public function getCommentaire() {
		return $this->commentaire;
	}

	/**
	 * Set adressIp
	 *
	 * @param string $adressIp
	 * @return User
	 */
	public function addAdressIp($adressIp) {
		$this->adressIps[] = $adressIp;
	
		return $this;
	}

	/**
	 * Remove adressIp
	 *
	 * @param array $adressIp
	 * @return User
	 */
	public function removeAdressIp($adressIp) {
		$this->adressIps->removeElement($adressIps);
	
		return $this;
	}

	/**
	 * Get adressIps
	 *
	 * @return array 
	 */
	public function getAdressIps() {
		return $this->adressIps;
	}

	/**
	 * Set tel
	 *
	 * @param string $tel
	 * @return User
	 */
	public function setTel($tel) {
		$this->tel = $tel;
	
		return $this;
	}

	/**
	 * Get tel
	 *
	 * @return string 
	 */
	public function getTel() {
		return $this->tel;
	}

	/**
	 * Add panier
	 *
	 * @param panier $panier
	 * @return User
	 */
	public function addPanier(panier $panier) {
		$this->paniers[] = $panier;
		return $this;
	}

	/**
	 * Remove panier
	 *
	 * @param panier $panier
	 */
	public function removePanier(panier $panier) {
		$this->paniers->removeElement($panier);
	}

	/**
	 * Get paniers
	 *
	 * @return ArrayCollection 
	 */
	public function getPaniers() {
		return $this->paniers;
	}

	/**
	 * Add images
	 *
	 * @param image $images
	 * @return User
	 */
	public function addImage(image $images) {
		$this->images[] = $images;
		return $this;
	}

	/**
	 * Remove images
	 *
	 * @param image $images
	 */
	public function removeImage(image $images) {
		$this->images->removeElement($images);
		$images->setUser(null); // relation facultative !!! (nullable = true)
	}

	/**
	 * Get images
	 *
	 * @return ArrayCollection 
	 */
	public function getImages() {
		return $this->images;
	}

	/**
	 * Add videos
	 *
	 * @param video $videos
	 * @return User
	 */
	public function addVideo(video $videos) {
		$this->videos[] = $videos;
		$videos->setUser($this); // ajout pour relation bidirectionnelle
		return $this;
	}

	/**
	 * Remove videos
	 *
	 * @param video $videos
	 */
	public function removeVideo(video $videos) {
		$this->videos->removeElement($videos);
		$videos->setUser(null); // relation facultative !!! (nullable = true)
	}

	/**
	 * Get videos
	 *
	 * @return ArrayCollection 
	 */
	public function getVideos() {
		return $this->videos;
	}

	/**
	 * Add articles
	 *
	 * @param article $articles
	 * @return User
	 */
	public function addArticle(article $articles) {
		$this->articles[] = $articles;
		$articles->setUser($this); // ajout pour relation bidirectionnelle
		return $this;
	}

	/**
	 * Remove articles
	 *
	 * @param article $articles
	 */
	public function removeArticle(article $articles) {
		$this->articles->removeElement($articles);
		$articles->setUser(null); // relation facultative !!! (nullable = true)
	}

	/**
	 * Get articles
	 *
	 * @return ArrayCollection 
	 */
	public function getArticles() {
		return $this->articles;
	}

	/**
	 * Add evenements
	 *
	 * @param evenement $evenements
	 * @return User
	 */
	public function addEvenement(evenement $evenements) {
		$this->evenements[] = $evenements;
		$evenements->setUser($this); // ajout pour relation bidirectionnelle
		return $this;
	}

	/**
	 * Remove evenements
	 *
	 * @param evenement $evenements
	 */
	public function removeEvenement(evenement $evenements) {
		$this->evenements->removeElement($evenements);
		$evenements->setUser(null); // relation facultative !!! (nullable = true)
	}

	/**
	 * Get evenements
	 *
	 * @return ArrayCollection 
	 */
	public function getEvenements() {
		return $this->evenements;
	}

	/**
	 * Add fiche
	 *
	 * @param fiche $fiche
	 * @return User
	 */
	public function addFiche(fiche $fiche) {
		$this->fiches[] = $fiche;
		$fiche->setUser($this); // ajout pour relation bidirectionnelle
		return $this;
	}

	/**
	 * Remove fiche
	 *
	 * @param fiche $fiche
	 */
	public function removeFiche(fiche $fiche) {
		$this->fiches->removeElement($fiche);
		$fiche->setUser(null); // relation facultative !!! (nullable = true)
	}

	/**
	 * Get fiches
	 *
	 * @return ArrayCollection 
	 */
	public function getFiches() {
		return $this->fiches;
	}

	/**
	 * Add fichierPdfs
	 *
	 * @param fichierPdf $fichierPdfs
	 * @return User
	 */
	public function addFichierPdf(fichierPdf $fichierPdfs) {
		$this->fichierPdfs[] = $fichierPdfs;
		$fichierPdfs->setUser($this); // ajout pour relation bidirectionnelle
		return $this;
	}

	/**
	 * Remove fichierPdfs
	 *
	 * @param fichierPdf $fichierPdfs
	 */
	public function removeFichierPdf(fichierPdf $fichierPdfs) {
		$this->fichierPdfs->removeElement($fichierPdfs);
		$fichierPdfs->setUser(null); // relation facultative !!! (nullable = true)
	}

	/**
	 * Get fichierPdfs
	 *
	 * @return ArrayCollection 
	 */
	public function getFichierPdfs() {
		return $this->fichierPdfs;
	}

	/**
	 * Add richtexts
	 *
	 * @param richtext $richtexts
	 * @return User
	 */
	public function addRichtext(richtext $richtexts) {
		$this->richtexts[] = $richtexts;
		$richtexts->setUser($this); // ajout pour relation bidirectionnelle
		return $this;
	}

	/**
	 * Remove richtexts
	 *
	 * @param richtext $richtexts
	 */
	public function removeRichtext(richtext $richtexts) {
		$this->richtexts->removeElement($richtexts);
		$richtexts->setUser(null); // relation facultative !!! (nullable = true)
	}

	/**
	 * Get richtexts
	 *
	 * @return ArrayCollection 
	 */
	public function getRichtexts() {
		return $this->richtexts;
	}

    /**
     * Set avatar
     *
     * @param image $avatar
     * @return User
     */
    public function setAvatar(image $avatar)
    {
        $this->avatar = $avatar;
    
        return $this;
    }

    /**
     * Get avatar
     *
     * @return image 
     */
    public function getAvatar()
    {
        return $this->avatar;
    }




}