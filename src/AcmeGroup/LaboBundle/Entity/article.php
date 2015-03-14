<?php

namespace AcmeGroup\LaboBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
// Slug
use Gedmo\Mapping\Annotation as Gedmo;
use labo\Bundle\TestmanuBundle\Entity\entityBase;
// Entities
use AcmeGroup\LaboBundle\Entity\statut;
use AcmeGroup\LaboBundle\Entity\version;
use AcmeGroup\LaboBundle\Entity\cuisson;
use AcmeGroup\LaboBundle\Entity\video;
use AcmeGroup\LaboBundle\Entity\unite;
use AcmeGroup\LaboBundle\Entity\tva;
use AcmeGroup\LaboBundle\Entity\image;
use AcmeGroup\LaboBundle\Entity\fiche;
// User
use AcmeGroup\UserBundle\Entity\User;
// aeReponse
use labo\Bundle\TestmanuBundle\services\aetools\aeReponse;

/**
 * article
 *
 * @ORM\Entity
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="AcmeGroup\LaboBundle\Entity\articleRepository")
 */
class article extends entityBase {

	/**
	 * @var string
	 *
	 * @ORM\Column(name="descriptif", type="text", nullable=true, unique=false)
	 */
	protected $descriptif;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="conseil", type="text", nullable=true, unique=false)
	 */
	protected $conseil;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="accroche", type="string", length=60, nullable=true, unique=false)
	 * @Assert\Length(
	 *      max = "60",
	 *      maxMessage = "L'accroche doit comporter au maximum {{ limit }} lettres."
	 * )
	 */
	protected $accroche;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="styleAccroche", type="string", length=60, nullable=true, unique=false)
	 */
	protected $styleAccroche;

	/**
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\LaboBundle\Entity\statut")
	 * @ORM\JoinColumn(nullable=false, unique=false)
	 */
	protected $statut;

	/**
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\LaboBundle\Entity\unite")
	 * @ORM\JoinColumn(nullable=false, unique=false)
	 */
	protected $unite;

	/**
	 * @var float
	 *
	 * @ORM\Column(name="prix", type="decimal", scale=2, nullable=true, unique=false)
	 */
	protected $prix;

	/**
	 * @var float
	 *
	 * @ORM\Column(name="prixHT", type="decimal", scale=2, nullable=true, unique=false)
	 */
	protected $prixHT;

	/**
	 * @var string
	 *
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\LaboBundle\Entity\tva")
	 * @ORM\JoinColumn(nullable=false)
	 */
	protected $tva;

	/**
	 * @var boolean
	 *
	 * @ORM\Column(name="plusVisible", type="boolean", nullable=true, unique=false)
	 */
	protected $plusVisible;

	/**
	 * @var array
	 *
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\LaboBundle\Entity\image", inversedBy="articlesIP")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $imagePpale;

	/**
	 * @var array
	 *
	 * @ORM\ManyToMany(targetEntity="AcmeGroup\LaboBundle\Entity\image", inversedBy="articles")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $images;

	/**
	 * @var array
	 *
	 * @ORM\ManyToMany(targetEntity="AcmeGroup\LaboBundle\Entity\cuisson", inversedBy="articles")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $cuissons;

	/**
	 * @var array
	 *
	 * @ORM\ManyToMany(targetEntity="AcmeGroup\LaboBundle\Entity\video", inversedBy="articles")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $videos;

	/**
	 * @var array
	 *
	 * @ORM\ManyToMany(targetEntity="AcmeGroup\LaboBundle\Entity\fiche", inversedBy="articles")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $fiches;

	/**
	 * @var array
	 *
	 * @ORM\ManyToMany(targetEntity="AcmeGroup\LaboBundle\Entity\categorie")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $categories;

	/**
	 * @var array
	 *
	 * @ORM\ManyToMany(targetEntity="AcmeGroup\LaboBundle\Entity\article", mappedBy="articlesLies")
	 */
	protected $articlesParents;

	/**
	 * @var array
	 *
	 * @ORM\ManyToMany(targetEntity="AcmeGroup\LaboBundle\Entity\article", inversedBy="articlesParents")
	 * @ORM\JoinTable(name="articlesLinks",
	 *     joinColumns={@ORM\JoinColumn(name="articlesLies_id", referencedColumnName="id")},
	 *     inverseJoinColumns={@ORM\JoinColumn(name="articlesParents_id", referencedColumnName="id")}
	 * )
	 */
	protected $articlesLies;

	/**
	 * @var array
	 *
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\LaboBundle\Entity\version")
	 * @ORM\JoinColumn(nullable=false, unique=false)
	 */
	protected $version;

	/**
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\UserBundle\Entity\User", inversedBy="articles")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $user;


	public function __construct() {
		parent::__construct();

		$this->styleAccroche = "normal";
		$this->plusVisible = false;

		$this->images = new ArrayCollection();
		$this->cuissons = new ArrayCollection();
		$this->videos = new ArrayCollection();
		$this->fiches = new ArrayCollection();
		$this->categories = new ArrayCollection();
		$this->articlesParents = new ArrayCollection();
		$this->articlesLies = new ArrayCollection();
	}

	/**
	 * @Assert/True(message = "Cet article n'est pas valide.")
	 */
	public function isArticleValid() {
		return true;
	}

	/**
	 * Set nom
	 *
	 * @param string $nom
	 * @return article
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
	 * Set descriptif
	 *
	 * @param string $descriptif
	 * @return article
	 */
	public function setDescriptif($descriptif) {
		$this->descriptif = $descriptif;
	
		return $this;
	}

	/**
	 * Get descriptif
	 *
	 * @return string 
	 */
	public function getDescriptif() {
		return $this->descriptif;
	}

	/**
	 * Set conseil
	 *
	 * @param string $conseil
	 * @return article
	 */
	public function setConseil($conseil) {
		$this->conseil = $conseil;
	
		return $this;
	}

	/**
	 * Get conseil
	 *
	 * @return string 
	 */
	public function getConseil() {
		return $this->conseil;
	}

	/**
	 * Set accroche
	 *
	 * @param string $accroche
	 * @return article
	 */
	public function setAccroche($accroche) {
		$this->accroche = $accroche;
	
		return $this;
	}

	/**
	 * Get accroche
	 *
	 * @return string 
	 */
	public function getAccroche() {
		return $this->accroche;
	}

	/**
	 * Set styleAccroche
	 *
	 * @param string $styleAccroche
	 * @return article
	 */
	public function setStyleAccroche($styleAccroche) {
		$this->styleAccroche = $styleAccroche;
	
		return $this;
	}

	/**
	 * Get styleAccroche
	 *
	 * @return string 
	 */
	public function getStyleAccroche() {
		return $this->styleAccroche;
	}

	/**
	 * Set statut
	 *
	 * @param statut $statut
	 * @return article
	 */
	public function setStatut(statut $statut) {
		$this->statut = $statut;
	
		return $this;
	}

	/**
	 * Get statut
	 *
	 * @return statut 
	 */
	public function getStatut() {
		return $this->statut;
	}

	/**
	 * Set unite
	 *
	 * @param unite $unite
	 * @return article
	 */
	public function setUnite(unite $unite) {
		$this->unite = $unite;
	
		return $this;
	}

	/**
	 * Get unite
	 *
	 * @return unite 
	 */
	public function getUnite() {
		return $this->unite;
	}

	/**
	 * Set prix
	 *
	 * @param float $prix
	 * @return article
	 */
	public function setPrix($prix) {
		$this->prix = $prix;
		$this->prixHT = $prix / (1 + ($this->tva->getTaux() / 100));
		return $this;
	}

	/**
	 * Get prix
	 *
	 * @return float 
	 */
	public function getPrix() {
		return $this->prix;
	}

	/**
	 * Set prixHT
	 *
	 * @param float $prixHT
	 * @return article
	 */
	public function setPrixHT($prixHT = null) {
		if($prixHT !== null) {
			$this->prixHT = $prixHT;
			$this->prix = $prixHT * (1 + ($this->tva->getTaux() / 100));
		}
		return $this;
	}

	/**
	 * Get prixHT
	 *
	 * @return float 
	 */
	public function getPrixHT() {
		return $this->prixHT;
	}

	/**
	 * Get TVA
	 *
	 * @return float 
	 */
	public function getMontantTva() {
		return $this->prixHT * ($this->tva->getTaux() / 100);
	}

	/**
	 * Set tva
	 *
	 * @param tva $tva
	 * @return article
	 */
	public function setTva(tva $tva) {
		$this->tva = $tva;
	
		return $this;
	}

	/**
	 * Get tva
	 *
	 * @return tva 
	 */
	public function getTva() {
		return $this->tva;
	}

	/**
	 * Set plusVisible
	 *
	 * @param boolean $plusVisible
	 * @return article
	 */
	public function setPlusVisible($plusVisible = true) {
		if($plusVisible === true) $this->plusVisible = $plusVisible;
			else $this->plusVisible = false;

		return $this;
	}

	/**
	 * Get plusVisible
	 *
	 * @return boolean
	 */
	public function getPlusVisible() {
		return $this->plusVisible;
	}

	/**
	 * Set imagePpale
	 *
	 * @param image $imagePpale
	 * @return article
	 */
	public function setImagePpale(image $imagePpale = null) {
		$this->imagePpale = $imagePpale;
	
		return $this;
	}

	/**
	 * Get imagePpale
	 *
	 * @return image 
	 */
	public function getImagePpale() {
		return $this->imagePpale;
	}

	/**
	 * Add images
	 *
	 * @param image $images
	 * @return article
	 */
	public function addImage(image $images = null) {
		if($images !== null) {
			$this->images[] = $images;

		}
	
		return $this;
	}

	/**
	 * Remove images
	 *
	 * @param image $images
	 */
	public function removeImage(image $images = null) {
		if($images !== null) {
			$this->images->removeElement($images);
		}
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
	 * Add cuissons
	 *
	 * @param cuisson $cuissons
	 * @return article
	 */
	public function addCuisson(cuisson $cuissons = null) {
		if($cuissons !== null) $this->cuissons[] = $cuissons;
	
		return $this;
	}

	/**
	 * Remove cuissons
	 *
	 * @param cuisson $cuissons
	 */
	public function removeCuisson(cuisson $cuissons = null) {
		if($cuissons !== null) $this->cuissons->removeElement($cuissons);
	}

	/**
	 * Get cuissons
	 *
	 * @return ArrayCollection 
	 */
	public function getCuissons() {
		return $this->cuissons;
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
	 * Add video
	 *
	 * @param video $video
	 * @return article
	 */
	public function addVideo(video $video = null) {
		if($video !== null) {
			$this->videos[] = $video;
			$video->addArticle($this);
		}
	
		return $this;
	}

	/**
	 * Remove video
	 *
	 * @param video $video
	 */
	public function removeVideo(video $video = null) {
		if($video !== null) {
			$this->videos->removeElement($video);
			$video->removeArticle($this);
		}
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
	 * Add fiche
	 *
	 * @param fiche $fiche
	 * @return article
	 */
	public function addFiche(fiche $fiche = null) {
		if($fiche !== null) {
			$this->fiches[] = $fiche;
			$fiche->addArticle($this);
		}
	
		return $this;
	}

	/**
	 * Remove fiche
	 *
	 * @param fiche $fiche
	 */
	public function removeFiche(fiche $fiche = null) {
		if($fiche !== null) {
			$this->fiches->removeElement($fiche);
			$fiche->removeArticle($this);
		}
	}

	/**
	 * Get categories
	 *
	 * @return ArrayCollection 
	 */
	public function getCategories() {
		return $this->categories;
	}

	/**
	 * Add categories
	 *
	 * @param categorie $categories
	 * @return article
	 */
	public function addCategorie(categorie $categories) {
		$this->categories[] = $categories;
	
		return $this;
	}

	/**
	 * Remove categories
	 *
	 * @param categorie $categories
	 */
	public function removeCategorie(categorie $categories) {
		$this->categories->removeElement($categories);
	}

	/**
	 * Add articlesParents
	 *
	 * @param article $articlesParents
	 * @return article
	 */
	public function addArticlesParent(article $articlesParents) {
		$this->articlesParents[] = $articlesParents;
	
		return $this;
	}

	/**
	 * Remove articlesParents
	 *
	 * @param article $articlesParents
	 */
	public function removeArticlesParent(article $articlesParents) {
		$this->articlesParents->removeElement($articlesParents);
	}

	/**
	 * Get articlesParents
	 *
	 * @return ArrayCollection 
	 */
	public function getArticlesParents() {
		return $this->articlesParents;
	}

	/**
	 * Add articlesLies
	 *
	 * @param article $articlesLies
	 * @return article
	 */
	public function addArticlesLie(article $articlesLies) {
		$this->articlesLies[] = $articlesLies;
		$articlesLies->addArticlesParent($this);
		return $this;
	}

	/**
	 * Remove articlesLies
	 *
	 * @param article $articlesLies
	 */
	public function removeArticlesLie(article $articlesLies) {
		$this->articlesLies->removeElement($articlesLies);
		$articlesLies->removeArticlesParent($this);
	}

	/**
	 * Get articlesLies
	 *
	 * @return ArrayCollection 
	 */
	public function getArticlesLies() {
		return $this->articlesLies;
	}

	/**
	 * Set version
	 *
	 * @param string $version
	 * @return article
	 */
	public function setVersion($version) {
		$this->version = $version;
	
		return $this;
	}

	/**
	 * Get version
	 *
	 * @return string 
	 */
	public function getVersion() {
		return $this->version;
	}

}
