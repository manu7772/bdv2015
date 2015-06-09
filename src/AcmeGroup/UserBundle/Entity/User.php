<?php
// src/AcmeGroup/UserBundle/Entity/User.php
 
namespace AcmeGroup\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;

use AcmeGroup\LaboBundle\Entity\adresse;
use AcmeGroup\LaboBundle\Entity\telephone;
use AcmeGroup\LaboBundle\Entity\panier;
use AcmeGroup\LaboBundle\Entity\image;
use AcmeGroup\LaboBundle\Entity\video;
use AcmeGroup\LaboBundle\Entity\article;
use AcmeGroup\LaboBundle\Entity\evenement;
use AcmeGroup\LaboBundle\Entity\fiche;
use AcmeGroup\LaboBundle\Entity\fichierPdf;
use AcmeGroup\LaboBundle\Entity\richtext;

/**
 * @ORM\Entity
 * @ORM\Table(name="User")
 * @ORM\Entity(repositoryClass="AcmeGroup\UserBundle\Entity\UserRepository")
 */
class User extends BaseUser {

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
	 * @ORM\JoinColumn(nullable=true, unique=true)
	 * @Assert\Valid()
	 */
	protected $avatar;

	/**
	 * @var array
	 * @ORM\Column(name="preferences", type="array", nullable=true)
	 */
	protected $preferences;

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
	protected $nom;

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
	protected $prenom;

	/**
	 * @var integer
	 *
	 * @ORM\OneToMany(targetEntity="AcmeGroup\LaboBundle\Entity\adresse", mappedBy="user", cascade={"persist", "remove"})
	 * @ORM\JoinColumn(nullable=true, unique=true)
	 */
	protected $adresses;

	/**
	 * @var integer
	 *
	 * @ORM\OneToMany(targetEntity="AcmeGroup\LaboBundle\Entity\telephone", mappedBy="user", cascade={"persist", "remove"})
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 * @Assert\Valid()
	 */
	protected $telephones;

	/**
	 * @var integer
	 *
	 * @ORM\OneToMany(targetEntity="AcmeGroup\LaboBundle\Entity\email", mappedBy="user", cascade={"persist", "remove"})
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 * @Assert\Valid()
	 */
	protected $autremails;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="commentaire", type="text", nullable=true, unique=false)
	 */
	protected $commentaire;

	/**
	 * @var array
	 *
	 * @ORM\Column(name="adressIp", type="array", nullable=true)
	 */
	protected $adressIps;

	/**
	 * @var array
	 *
	 * @ORM\OneToMany(targetEntity="AcmeGroup\LaboBundle\Entity\panier", mappedBy="user", cascade={"persist", "remove"})
	 * @ORM\JoinColumn(nullable=true)
	 * @Assert\Valid()
	 */
	protected $paniers;

	/**
	 * @var array
	 *
	 * @ORM\OneToMany(targetEntity="AcmeGroup\LaboBundle\Entity\image", mappedBy="user")
	 * @ORM\JoinColumn(nullable=true)
	 */
	protected $images;

	/**
	 * @var array
	 *
	 * @ORM\OneToMany(targetEntity="AcmeGroup\LaboBundle\Entity\video", mappedBy="user")
	 * @ORM\JoinColumn(nullable=true)
	 */
	protected $videos;

	/**
	 * @var array
	 *
	 * @ORM\OneToMany(targetEntity="AcmeGroup\LaboBundle\Entity\fiche", mappedBy="user")
	 * @ORM\JoinColumn(nullable=true)
	 */
	protected $fiches;

	/**
	 * @var array
	 *
	 * @ORM\OneToMany(targetEntity="AcmeGroup\LaboBundle\Entity\article", mappedBy="user")
	 * @ORM\JoinColumn(nullable=true)
	 */
	protected $articles;

	/**
	 * @var array
	 *
	 * @ORM\OneToMany(targetEntity="AcmeGroup\LaboBundle\Entity\evenement", mappedBy="user")
	 * @ORM\JoinColumn(nullable=true)
	 */
	protected $evenements;

	/**
	 * @var array
	 *
	 * @ORM\OneToMany(targetEntity="AcmeGroup\LaboBundle\Entity\fichierPdf", mappedBy="user")
	 * @ORM\JoinColumn(nullable=true)
	 */
	protected $fichierPdfs;

	/**
	 * @var array
	 *
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\LaboBundle\Entity\version", inversedBy="users")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $version;


	public function __construct() {
		parent::__construct();

		$this->adresses = new ArrayCollection();
		$this->telephones = new ArrayCollection();
		$this->autremails = new ArrayCollection();
		$this->adressIps = new ArrayCollection();
		$this->paniers = new ArrayCollection();
		$this->images = new ArrayCollection();
		$this->videos = new ArrayCollection();
		$this->fiches = new ArrayCollection();
		$this->articles = new ArrayCollection();
		$this->evenements = new ArrayCollection();
		$this->fichierPdfs = new ArrayCollection();
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
	 * Ajoute preference $nom. 
	 * Renvoie le nom (pour confirmation)
	 * @param mixed $preference
	 * @param string $nom = null
	 * @return string
	 */
	public function addPreference($preference, $nom = null) {
		if(is_string($nom)) {
			$this->preferences->set($nom, $preference);
		} else {
			$this->preferences->add($preference);
			$nom = key($this->preferences);
		}
		return $nom;
	}

	/**
	 * Supprime preference
	 *
	 * @param mixed $preference
	 * @param string $nom = null
	 * @return boolean
	 */
	public function removePreference($preference) {
		return $this->preferences->removeElement($preference);
	}

	/**
	 * Supprime preference selon le $nom
	 *
	 * @param string $nom
	 * @return mixed
	 */
	public function removePreferenceByNom($nom) {
		return $this->preferences->remove($nom);
	}

	/**
	 * Supprime toutes les preferences
	 *
	 * @param mixed $preference
	 * @return boolean
	 */
	public function removeAllPreferences() {
		return $this->preferences->clear();
	}

	/**
	 * Renvoie toutes les preferences
	 *
	 * @return ArrayCollection 
	 */
	public function getPreferences() {
		return $this->preferences;
	}

	/**
	 * Ajoute une adresse
	 * @param adresse $adresse
	 * @return User
	 */
	public function addAdresse(adresse $adresse) {
		$this->adresses->add($adresse);
		$adresse->setUser($this);
		return $this;
	}

	/**
	 * Supprime une adresse
	 * @param adresse $adresse
	 * @return boolean
	 */
	public function removeAdresse(adresse $adresse) {
		$adresse->setUser(null);
		return $this->adresses->removeElement($adresse);
	}

	/**
	 * Renvoie les adresses
	 *
	 * @return arrayCollection
	 */
	public function getAdresses() {
		return $this->adresses;
	}

	/**
	 * Ajoute un telephone
	 * @param telephone $telephone
	 * @return User
	 */
	public function addTelephone(telephone $telephone) {
		$this->telephones->add($telephone);
		$telephone->setUser($this);
		return $this;
	}

	/**
	 * Supprime une telephone
	 * @param telephone $telephone
	 * @return boolean
	 */
	public function removeTelephone(telephone $telephone) {
		$telephone->setUser(null);
		return $this->telephones->removeElement($telephone);
	}

	/**
	 * Renvoie les telephones
	 *
	 * @return arrayCollection
	 */
	public function getTelephones() {
		return $this->telephones;
	}

	/**
	 * Ajoute un autremail
	 * @param autremail $autremail
	 * @return User
	 */
	public function addAutremail(autremail $autremail) {
		$this->autremails->add($autremail);
		$autremail->setUser($this);
		return $this;
	}

	/**
	 * Supprime une autremail
	 * @param autremail $autremail
	 * @return boolean
	 */
	public function removeAutremail(autremail $autremail) {
		$autremail->setUser(null);
		return $this->autremails->removeElement($autremail);
	}

	/**
	 * Renvoie les autremails
	 *
	 * @return arrayCollection
	 */
	public function getAutremails() {
		return $this->autremails;
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
		$this->adressIps->add($adressIp);
	
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
	 * Ajoute au panier
	 *
	 * @param panier $panier
	 * @return User
	 */
	public function addPanier(panier $panier) {
		$this->paniers->add($panier);
		return $this;
	}

	/**
	 * Supprime du panier
	 *
	 * @param panier $panier
	 */
	public function removePanier(panier $panier) {
		$this->paniers->removeElement($panier);
	}

	/**
	 * Supprime tout le contenu du panier
	 *
	 * @param panier $panier
	 */
	public function removeAllPaniers() {
		$this->paniers->clear();
	}

	/**
	 * Renvoie le contenu du panier
	 *
	 * @return ArrayCollection 
	 */
	public function getPaniers() {
		return $this->paniers;
	}

	/**
	 * Add image
	 *
	 * @param image $image
	 * @return User
	 */
	public function addImage(image $image) {
		$this->images->add($image);
		$image->setUser($this);
		return $this;
	}

	/**
	 * Remove image
	 *
	 * @param image $image
	 */
	public function removeImage(image $image) {
		$this->images->removeElement($image);
		$image->setUser(null); // relation facultative !!! (nullable = true)
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
	 * Set avatar
	 * @param image $avatar
	 * @return User
	 */
	public function setAvatar(image $avatar = null) {
		$this->avatar = $avatar;
		return $this;
	}

	/**
	 * Get avatar
	 * @return image 
	 */
	public function getAvatar() {
		return $this->avatar;
	}




}