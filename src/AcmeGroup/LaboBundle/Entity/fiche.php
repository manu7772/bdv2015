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
use AcmeGroup\LaboBundle\Entity\typeFiche;
// User
use AcmeGroup\UserBundle\Entity\User;

use \Exception;
use \DateTime;

/**
 * fiche
 *
 * @ORM\Entity
 * @ORM\Table(name="fiche")
 * @ORM\Entity(repositoryClass="AcmeGroup\LaboBundle\Entity\ficheRepository")
 * @UniqueEntity(fields={"nom", "version", "statut"}, message="Cette fiche existe déjà.")
 */
class fiche extends baseType {

	/**
	 * @var array
	 * @ORM\ManyToMany(targetEntity="AcmeGroup\LaboBundle\Entity\image")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $images;

	/**
	 * @var array
	 * @ORM\ManyToMany(targetEntity="AcmeGroup\LaboBundle\Entity\video", inversedBy="fiches")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $videos;

	/**
	 * @ORM\ManyToMany(targetEntity="AcmeGroup\LaboBundle\Entity\typeFiche")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $typeFiches;

	/**
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\UserBundle\Entity\User", inversedBy="fiches")
	 * @ORM\JoinColumn(nullable=true, unique=true)
	 */
	protected $user;

	/**
	 * @ORM\ManyToMany(targetEntity="AcmeGroup\LaboBundle\Entity\article", mappedBy="fiches")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $articles;


	public function __construct() {
		parent::__construct();
		$this->images = new ArrayCollection();
		$this->articles = new ArrayCollection();
		$this->typeFiches = new ArrayCollection();
	}


// DEBUT --------------------- à inclure dans toutes les entités ------------------------

	/**
	 * Renvoie true si l'entité est valide
	 * @Assert\True(message = "Cette fiche n'est pas valide.")
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
	 * Add image
	 * @param image $image
	 * @return fiche
	 */
	public function addImage(image $image = null) {
		if($image !== null) $this->images->add($image);
		return $this;
	}

	/**
	 * Remove image
	 * @param image $image
	 * @return fiche
	 */
	public function removeImage(image $image = null) {
		if($image !== null) $this->images->removeElement($image);
		return $this;
	}

	/**
	 * Get images
	 * @return arrayCollection 
	 */
	public function getImages() {
		return $this->images;
	}

	/**
	 * Add video
	 * @param video $video
	 * @return fiche
	 */
	public function addVideo(video $video = null) {
		if($video !== null) {
			$this->videos->add($video);
			$video->addFiche($this);
		}
		return $this;
	}

	/**
	 * Remove video
	 * @param video $video
	 * @return fiche
	 */
	public function removeVideo(video $video = null) {
		if($video !== null) {
			$this->videos->removeElement($video);
			$video->removeElement($this);
		}
		return $this;
	}

	/**
	 * Get videos
	 * @return arrayCollection 
	 */
	public function getVideos() {
		return $this->videos;
	}

	/**
	 * Ajoute typeFiche
	 * @param typeFiche $typeFiche
	 * @return fiche
	 */
	public function addTypeFiche(typeFiche $typeFiche = null) {
		if($typeFiche !== null) $this->typeFiches->add($typeFiche);
		return $this;
	}

	/**
	 * Supprime typeFiche
	 * @param typeFiche $typeFiche
	 * @return image
	 */
	public function removeTypeFiche(typeFiche $typeFiche = null) {
		if($typeFiche !== null) $this->typeFiches->removeElement($typeFiche);
		return $this;
	}

	/**
	 * Renvoie typeFiches
	 * @return ArrayCollection 
	 */
	public function getTypeFiches() {
		return $this->typeFiches;
	}

	/**
	 * Set user
	 * @param User $user
	 * @return fiche
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

	/**
	 * Ajoute article
	 * @param article $article
	 * @return fiche
	 */
	public function addArticle(article $article = null) {
		if($article !== null) {
			$this->articles->add($article);
			$article->addFiche($this);
		}
		return $this;
	}

	/**
	 * Supprime article
	 * @param article $article
	 * @return fiche
	 */
	public function removeArticle(article $article = null) {
		if($article !== null) {
			$this->articles->removeElement($article);
			$article->removeElement($this);
		}
		return $this;
	}

	/**
	 * Renvoie articles
	 * @return ArrayCollection 
	 */
	public function getArticles() {
		return $this->articles;
	}


}
