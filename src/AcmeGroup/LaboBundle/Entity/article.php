<?php

namespace AcmeGroup\LaboBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
// Slug
use Gedmo\Mapping\Annotation as Gedmo;
use AcmeGroup\LaboBundle\Entity\baseL3EntityAttributs;
// Entities
use AcmeGroup\LaboBundle\Entity\cuisson;
use AcmeGroup\LaboBundle\Entity\video;
use AcmeGroup\LaboBundle\Entity\unite;
use AcmeGroup\LaboBundle\Entity\tva;
use AcmeGroup\LaboBundle\Entity\image;
use AcmeGroup\LaboBundle\Entity\fiche;
// User
use AcmeGroup\UserBundle\Entity\User;

use \Exception;
use \DateTime;

/**
 * article
 *
 * @ORM\Entity
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="AcmeGroup\LaboBundle\Entity\articleRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class article extends baseL3EntityAttributs {

	const RATIO_TAUX_TVA		= 100;

	/**
	 * @var string
	 * @ORM\Column(name="conseil", type="text", nullable=true, unique=false)
	 */
	protected $conseil;

	/**
	 * @var string
	 * @ORM\Column(name="accroche", type="string", length=60, nullable=true, unique=false)
	 * @Assert\Length(
	 *      max = "60",
	 *      maxMessage = "L'accroche doit comporter au maximum {{ limit }} lettres."
	 * )
	 */
	protected $accroche;

	/**
	 * @var string
	 * @ORM\Column(name="styleAccroche", type="string", length=60, nullable=true, unique=false)
	 */
	protected $styleAccroche;

	/**
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\LaboBundle\Entity\unite")
	 * @ORM\JoinColumn(nullable=false, unique=false)
	 */
	protected $unite;

	/**
	 * @var float
	 * @ORM\Column(name="prix", type="decimal", scale=2, nullable=true, unique=false)
	 */
	protected $prix;

	/**
	 * @var float
	 * @ORM\Column(name="prixHT", type="decimal", scale=2, nullable=true, unique=false)
	 */
	protected $prixHT;

	/**
	 * @var string
	 * 
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\LaboBundle\Entity\tva")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $tva;

	/**
	 * @var integer
	 * 
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\LaboBundle\Entity\image")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $imagePpale;

	/**
	 * @var array
	 * 
	 * @ORM\ManyToMany(targetEntity="AcmeGroup\LaboBundle\Entity\image")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $images;

	/**
	 * @var array
	 * 
	 * @ORM\OneToMany(targetEntity="AcmeGroup\LaboBundle\Entity\panier", mappedBy="article")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $paniers;

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
	 * @ORM\ManyToMany(targetEntity="AcmeGroup\LaboBundle\Entity\fiche", inversedBy="articles")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $fiches;

	/**
	 * @var array
	 * @ORM\ManyToMany(targetEntity="AcmeGroup\LaboBundle\Entity\categorie")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $categories;

	/**
	 * @var array
	 * @ORM\ManyToMany(targetEntity="AcmeGroup\LaboBundle\Entity\article", mappedBy="articlesLies")
	 */
	protected $articlesParents;

	/**
	 * @var array
	 * @ORM\ManyToMany(targetEntity="AcmeGroup\LaboBundle\Entity\article", inversedBy="articlesParents")
	 * @ORM\JoinTable(name="articlesLinks",
	 *     joinColumns={@ORM\JoinColumn(name="articlesLies_id", referencedColumnName="id")},
	 *     inverseJoinColumns={@ORM\JoinColumn(name="articlesParents_id", referencedColumnName="id")}
	 * )
	 */
	protected $articlesLies;

	/**
	 * @var integer
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\UserBundle\Entity\User", inversedBy="articles")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $user;

	protected $listeStyleAccroche;
	protected $montantTva;

	public function __construct() {
		parent::__construct();

		$this->listeStyleAccroche = array(
			"basse" 		=> "basse",
			"normale" 		=> "normale",
			"haute" 		=> "haute",
			"très haute" 	=> "très haute"
			);

		$this->styleAccroche = $this->listeStyleAccroche['normale'];

		$this->prix = 0.0;
		$this->prixHT = 0.0;
		$this->montantTva = 0.0;

		$this->images 			= new ArrayCollection();
		$this->paniers 			= new ArrayCollection();
		$this->cuissons 		= new ArrayCollection();
		$this->videos 			= new ArrayCollection();
		$this->fiches 			= new ArrayCollection();
		$this->categories 		= new ArrayCollection();
		$this->articlesParents 	= new ArrayCollection();
		$this->articlesLies 	= new ArrayCollection();
	}


// DEBUT --------------------- à inclure dans toutes les entités ------------------------

	/**
	 * Renvoie true si l'entité est valide
	 * @Assert\True(message = "Cet article n'est pas valide.")
	 * @return boolean
	 */
	public function isValid() {
		$valid = true;
		$valid = parent::isValid();
		if($valid === true) {
			// opérations pour cette entité
			// …
		}
		return $valid;
	}

	/**
	 * Complète les données avant enregistrement
	 * @ORM\PreUpdate
	 * @ORM\PrePersist
	 * @return boolean
	 */
	public function verify() {
		$verif = true;
		$verif = parent::verify();
		if($verif === true) {
			// Contrôle des prix / TVA
			if($this->tva instanceOf tva) {
				// recalcul des PrixHT / Prix(TTC) / TVA
				if($this->prixHT !== 0 && $this->prix == 0) {
					// si on n'a que le prix HT on calcule le prix TTC
					$this->prix = $prixHT * (1 + ($this->tva->getTaux() / self::RATIO_TAUX_TVA));
				} else {
					// sinon, on calcule le prix HT d'après le prix TTC
					// ---> !! le prix TTC est toujours vrai en priorité s'il est renseigné !!
					$this->prixHT = $this->prix / (1 + ($this->tva->getTaux() / self::RATIO_TAUX_TVA));
				}
			} else {
				// pas de TVA
				// throw new Exception("La TVA n'est pas renseignée !", 1);
			}
		}
		return $verif;
	}

	/**
	 * @ORM\PreRemove
	 */
	public function RemoveAllLinks() {
		if($this->getUser() !== NULL) {
			  $this->getUser()->RemoveElement($this);
		}
	}

// FIN --------------------- à inclure dans toutes les entités ------------------------


	/**
	 * Set conseil
	 * @param string $conseil
	 * @return article
	 */
	public function setConseil($conseil) {
		$this->conseil = $conseil;
	
		return $this;
	}

	/**
	 * Get conseil
	 * @return string 
	 */
	public function getConseil() {
		return $this->conseil;
	}

	/**
	 * Set accroche
	 * @param string $accroche
	 * @return article
	 */
	public function setAccroche($accroche) {
		$this->accroche = $accroche;
	
		return $this;
	}

	/**
	 * Get accroche
	 * @return string 
	 */
	public function getAccroche() {
		return $this->accroche;
	}

	/**
	 * Set styleAccroche
	 * @param string $styleAccroche
	 * @return article
	 */
	public function setStyleAccroche($styleAccroche) {
		$this->styleAccroche = $styleAccroche;
	
		return $this;
	}

	/**
	 * Get styleAccroche
	 * @return string 
	 */
	public function getStyleAccroche() {
		return $this->styleAccroche;
	}

	/**
	 * Set unite
	 * @param unite $unite
	 * @return article
	 */
	public function setUnite(unite $unite) {
		$this->unite = $unite;
	
		return $this;
	}

	/**
	 * Get unite
	 * @return unite 
	 */
	public function getUnite() {
		return $this->unite;
	}

	/**
	 * Set prix
	 * @param float $prix
	 * @return article
	 */
	public function setPrix($prix = 0) {
		$prix = floatval($prix);
		if(!is_float($prix)) $prix = 0.0;
		$this->prix = $prix;
		return $this;
	}

	/**
	 * Get prix
	 * @return float 
	 */
	public function getPrix() {
		return $this->prix;
	}

	/**
	 * Set prixHT
	 * @param float $prixHT
	 * @return article
	 */
	public function setPrixHT($prixHT = 0) {
		$prixHT = floatval($prixHT);
		if(!is_float($prixHT)) $prixHT = 0.0;
		$this->prixHT = $prixHT;
		return $this;
	}

	/**
	 * Get prixHT
	 * @return float 
	 */
	public function getPrixHT() {
		return $this->prixHT;
	}

	/**
	 * Get TVA
	 * @return float 
	 */
	public function getMontantTva() {
		$this->tva instanceOf tva ? $this->montantTva = $this->prixHT * ($this->tva->getTaux() / self::RATIO_TAUX_TVA) : $this->montantTva = false;
		return $this->montantTva;
	}

	/**
	 * Set tva
	 * @param tva $tva
	 * @return article
	 */
	public function setTva(tva $tva = null) {
		$this->tva = $tva;
		return $this;
	}

	/**
	 * Get tva
	 * @return tva 
	 */
	public function getTva() {
		return $this->tva;
	}

	/**
	 * Set imagePpale
	 * @param image $imagePpale
	 * @return article
	 */
	public function setImagePpale(image $imagePpale = null) {
		$this->imagePpale = $imagePpale;	
		return $this;
	}

	/**
	 * Get imagePpale
	 * @return image 
	 */
	public function getImagePpale() {
		return $this->imagePpale;
	}

	/**
	 * Add image
	 * @param image $image
	 * @return article
	 */
	public function addImage(image $image = null) {
		if($image !== null) {
			$this->images->add($image);

		}
	
		return $this;
	}

	/**
	 * Remove image
	 * @param image $image
	 */
	public function removeImage(image $image = null) {
		if($image !== null) {
			$this->images->removeElement($image);
		}
	}

	/**
	 * Get images
	 * @return ArrayCollection 
	 */
	public function getImages() {
		return $this->images;
	}

	/**
	 * Add paniers
	 * @param panier $paniers
	 * @return article
	 */
	public function addPanier(panier $paniers = null) {
		if($paniers !== null) {
			$this->paniers[] = $paniers;
		}
	
		return $this;
	}

	/**
	 * Remove paniers
	 * @param panier $paniers
	 */
	public function removePanier(panier $paniers = null) {
		if($paniers !== null) {
			$this->paniers->removeElement($paniers);
		}
	}

	/**
	 * Get paniers
	 * @return ArrayCollection 
	 */
	public function getPaniers() {
		return $this->paniers;
	}

	/**
	 * Add cuisson
	 * @param cuisson $cuisson
	 * @return article
	 */
	public function addCuisson(cuisson $cuisson = null) {
		if($cuisson !== null) {
			$this->cuissons->add($cuisson);
			$cuisson->addArticle($this);
		}
		return $this;
	}

	/**
	 * Remove cuisson
	 * @param cuisson $cuisson
	 * @return article
	 */
	public function removeCuisson(cuisson $cuisson = null) {
		if($cuisson !== null) {
			$this->cuissons->removeElement($cuisson);
			$cuisson->removecuisson($this);
		}
		return $this;
	}

	/**
	 * Get cuissons
	 * @return ArrayCollection 
	 */
	public function getCuissons() {
		return $this->cuissons;
	}

	/**
	 * Get videos
	 * @return ArrayCollection 
	 */
	public function getVideos() {
		return $this->videos;
	}

	/**
	 * Add video
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
	 * @return ArrayCollection 
	 */
	public function getFiches() {
		return $this->fiches;
	}

	/**
	 * Add fiche
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
	 * @return ArrayCollection 
	 */
	public function getCategories() {
		return $this->categories;
	}

	/**
	 * Add categories
	 * @param categorie $categories
	 * @return article
	 */
	public function addCategorie(categorie $categories) {
		$this->categories[] = $categories;
	
		return $this;
	}

	/**
	 * Remove categories
	 * @param categorie $categories
	 */
	public function removeCategorie(categorie $categories) {
		$this->categories->removeElement($categories);
	}

	/**
	 * Add articlesParents
	 * @param article $articlesParents
	 * @return article
	 */
	public function addArticlesParent(article $articlesParents) {
		$this->articlesParents[] = $articlesParents;
	
		return $this;
	}

	/**
	 * Remove articlesParents
	 * @param article $articlesParents
	 */
	public function removeArticlesParent(article $articlesParents) {
		$this->articlesParents->removeElement($articlesParents);
	}

	/**
	 * Get articlesParents
	 * @return ArrayCollection 
	 */
	public function getArticlesParents() {
		return $this->articlesParents;
	}

	/**
	 * Add articlesLies
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
	 * @param article $articlesLies
	 */
	public function removeArticlesLie(article $articlesLies) {
		$this->articlesLies->removeElement($articlesLies);
		$articlesLies->removeArticlesParent($this);
	}

	/**
	 * Get articlesLies
	 * @return ArrayCollection 
	 */
	public function getArticlesLies() {
		return $this->articlesLies;
	}

	/**
	 * Set user
	 * @param User $user
	 * @return article
	 */
	public function setUser(User $user = null) {
		$this->user = $user;
	
		return $this;
	}

	/**
	 * Get user
	 * @return User 
	 */
	public function getUser() {
		return $this->user;
	}

}
