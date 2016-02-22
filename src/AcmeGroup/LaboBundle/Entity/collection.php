<?php

namespace AcmeGroup\LaboBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
// Slug
use Gedmo\Mapping\Annotation as Gedmo;
use AcmeGroup\LaboBundle\Entity\baseType;
// Entities
use AcmeGroup\LaboBundle\Entity\image;
use AcmeGroup\LaboBundle\Entity\article;
use AcmeGroup\LaboBundle\Entity\fichierPdf;
use AcmeGroup\LaboBundle\Entity\video;
use AcmeGroup\LaboBundle\Entity\fiche;
use AcmeGroup\LaboBundle\Entity\typeCollection;

use \Exception;
use \DateTime;

/**
 * collection
 *
 * @ORM\Entity
 * @ORM\Table(name="collection")
 * @ORM\Entity(repositoryClass="AcmeGroup\LaboBundle\Entity\collectionRepository")
 * @UniqueEntity(fields={"nom", "version", "statut"}, message="Cette collection existe déjà.")
 */
class collection extends baseType {

	const DEFAULT_READ_RIGHT = 'ALL';
	const DEFAULT_WRITE_RIGHT = 'ROLE_ADMIN';
	const DEFAULT_DELETE_RIGHT = 'ROLE_ADMIN';

	/**
	 * @var array
	 *
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\LaboBundle\Entity\image")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $firstimage;

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
	 * @ORM\ManyToMany(targetEntity="AcmeGroup\LaboBundle\Entity\article")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $articles;

	/**
	 * @var array
	 *
	 * @ORM\ManyToMany(targetEntity="AcmeGroup\LaboBundle\Entity\fichierPdf")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $fichierPdfs;

	/**
	 * @var array
	 *
	 * @ORM\ManyToMany(targetEntity="AcmeGroup\LaboBundle\Entity\video")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $videos;

	/**
	 * @var array
	 *
	 * @ORM\ManyToMany(targetEntity="AcmeGroup\LaboBundle\Entity\fiche")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $fiches;

	/**
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\LaboBundle\Entity\typeCollection")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $typeCollection;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="vitesse", type="integer", nullable=false)
	 */
	protected $vitesse;

	protected $typesMedia;

	public function __construct() {
		parent::__construct();
		// attribution des droits
		$this->thisread = self::DEFAULT_READ_RIGHT;
		$this->thiswrite = self::DEFAULT_WRITE_RIGHT;
		$this->thisdelete = self::DEFAULT_DELETE_RIGHT;

		$this->typesMedia = array('image', 'article', 'fichierPdf', 'video', 'fiche');
		$this->firstmedia = null;
		$this->images = new ArrayCollection();
		$this->articles = new ArrayCollection();
		$this->fichierPdfs = new ArrayCollection();
		$this->videos = new ArrayCollection();
		$this->fiches = new ArrayCollection();
		$this->vitesse = 5000;
	}


// DEBUT --------------------- à inclure dans toutes les entités ------------------------

	/**
	 * Renvoie true si l'entité est valide
	 * @Assert\True(message = "Cette collection n'est pas valide.")
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
			// opérations pour cette entité
			// …
		}
		return $verif;
	}

// FIN --------------------- à inclure dans toutes les entités ------------------------

	/**
	 * Renvoie les types de médias disponibles
	 * @return array
	 */
	public function getTypesMedia() {
		return $this->typesMedia;
	}

	/**
	 * Set firstimage
	 *
	 * @param string $firstimage
	 * @return collection
	 */
	public function setFirstimage($firstimage) {
		$this->firstimage = $firstimage;
		return $this;
	}

	/**
	 * Get firstimage
	 *
	 * @return string 
	 */
	public function getFirstimage() {
		return $this->firstimage;
	}

	/**
	 * Add image
	 *
	 * @param image $image
	 * @return collection
	 */
	public function addImage(image $image) {
		$this->images[] = $image;
		return $this;
	}

	/**
	 * Remove image
	 *
	 * @param image $image
	 */
	public function removeImage(image $image) {
		$this->images->removeElement($image);
	}

	/**
	 * Get images
	 *
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getImages() {
		return $this->images;
	}

	/**
	 * Add article
	 *
	 * @param article $article
	 * @return collection
	 */
	public function addArticle(article $article) {
		$this->articles[] = $article;
		return $this;
	}

	/**
	 * Remove article
	 *
	 * @param article $article
	 */
	public function removeArticle(article $article) {
		$this->articles->removeElement($article);
	}

	/**
	 * Get articles
	 *
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getArticles() {
		return $this->articles;
	}

	/**
	 * Add fichierPdf
	 *
	 * @param fichierPdf $fichierPdf
	 * @return collection
	 */
	public function addFichierPdf(fichierPdf $fichierPdf) {
		$this->fichierPdfs[] = $fichierPdf;
		return $this;
	}

	/**
	 * Remove fichierPdf
	 *
	 * @param fichierPdf $fichierPdf
	 */
	public function removeFichierPdf(fichierPdf $fichierPdf) {
		$this->fichierPdfs->removeElement($fichierPdf);
	}

	/**
	 * Get fichierPdfs
	 *
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getFichierPdfs() {
		return $this->fichierPdfs;
	}

	/**
	 * Add video
	 *
	 * @param video $video
	 * @return collection
	 */
	public function addVideo(video $video) {
		$this->videos[] = $video;
		return $this;
	}

	/**
	 * Remove video
	 *
	 * @param video $video
	 */
	public function removeVideo(video $video) {
		$this->videos->removeElement($video);
	}

	/**
	 * Get videos
	 *
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getVideos() {
		return $this->videos;
	}

	/**
	 * Add fiche
	 *
	 * @param fiche $fiche
	 * @return collection
	 */
	public function addFiche(fiche $fiche) {
		$this->fiches[] = $fiche;
		return $this;
	}

	/**
	 * Remove fiche
	 *
	 * @param fiche $fiche
	 */
	public function removeFiche(fiche $fiche) {
		$this->fiches->removeElement($fiche);
	}

	/**
	 * Get fiches
	 *
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getFiches() {
		return $this->fiches;
	}

	/**
	 * Set vitesse
	 *
	 * @param integer $vitesse
	 * @return collection
	 */
	public function setVitesse($vitesse) {
		$this->vitesse = $vitesse;
		return $this;
	}

	/**
	 * Get vitesse
	 *
	 * @return integer 
	 */
	public function getVitesse() {
		return $this->vitesse;
	}

	/**
	 * Set typeCollection
	 *
	 * @param typeCollection $typeCollection
	 * @return collection
	 */
	public function setTypeCollection(typeCollection $typeCollection = null) {
		$this->typeCollection = $typeCollection;
		return $this;
	}

	/**
	 * Get typeCollection
	 *
	 * @return typeCollection
	 */
	public function getTypeCollection() {
		return $this->typeCollection;
	}


}
