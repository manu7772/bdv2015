<?php

namespace AcmeGroup\LaboBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
// Slug
use Gedmo\Mapping\Annotation as Gedmo;
use AcmeGroup\LaboBundle\Entity\baseL2Entity;
// Entities
use AcmeGroup\LaboBundle\Entity\article;
use AcmeGroup\LaboBundle\Entity\fiche;
use AcmeGroup\LaboBundle\Entity\image;
use AcmeGroup\LaboBundle\Entity\typeVideo;
// User
use AcmeGroup\UserBundle\Entity\User;

use \Exception;
use \DateTime;

/**
 * video
 *
 * @ORM\Entity
 * @ORM\Table(name="video")
 * @ORM\Entity(repositoryClass="AcmeGroup\LaboBundle\Entity\videoRepository")
 * @UniqueEntity(fields={"videoUrl", "version", "statut"}, message="Cette vidéo existe déjà")
 */
class video extends baseL2Entity {

	/**
	 * @var string
	 *
	 * @ORM\Column(name="videoUrl", type="text")
	 */
	protected $videoUrl;

	/**
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\LaboBundle\Entity\image")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $image;

	/**
	 * @ORM\ManyToMany(targetEntity="AcmeGroup\LaboBundle\Entity\article", mappedBy="videos")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $articles;

	/**
	 * @ORM\ManyToMany(targetEntity="AcmeGroup\LaboBundle\Entity\fiche", mappedBy="videos")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $fiches;

	/**
	 * @ORM\ManyToMany(targetEntity="AcmeGroup\LaboBundle\Entity\typeVideo")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $typeVideos;

	/**
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\UserBundle\Entity\User", inversedBy="videos")
	 * @ORM\JoinColumn(nullable=true, unique=true)
	 */
	protected $user;


	public function __construct() {
		parent::__construct();
		$this->articles = new ArrayCollection();
		$this->fiches = new ArrayCollection();
		$this->typeVideos = new ArrayCollection();
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
			// opérations pour cette entité
			// …
			// $this->setUniquefield(
			// 	$this->getVideoUrl()
			// 	."@".$this->getVersion()->getSlug()
			// );
		}
		return $verif;
	}

// FIN --------------------- à inclure dans toutes les entités ------------------------


	/**
	 * Définit videoUrl
	 * @param string $videoUrl
	 * @return video
	 */
	public function setVideoUrl($videoUrl) {
		$this->videoUrl = preg_replace('#^(((http|https)(://)(.+))/)?(.+)$#', '$6', $videoUrl);
		return $this;
	}

	/**
	 * Renvoie videoUrl
	 * @return string 
	 */
	public function getVideoUrl() {
		return $this->videoUrl;
	}

	/**
	 * Définit image
	 * @param image $image
	 * @return video
	 */
	public function setImage(image $image) {
		$this->image = $image;
		return $this;
	}

	/**
	 * Renvoie image
	 * @return image 
	 */
	public function getImage() {
		return $this->image;
	}

	/**
	 * Ajoute article
	 * @param article $article
	 * @return video
	 */
	public function addArticle(article $article = null) {
		if($article !== null) $this->articles->add($article);
		return $this;
	}

	/**
	 * Supprime article
	 * @param article $article
	 * @return video
	 */
	public function removeArticle(article $article = null) {
		if($article !== null) $this->articles->removeElement($article);
		return $this;
	}

	/**
	 * Renvoie articles
	 * @return ArrayCollection 
	 */
	public function getArticles() {
		return $this->articles;
	}

	/**
	 * Ajoute fiche
	 * @param fiche $fiche
	 * @return video
	 */
	public function addFiche(fiche $fiche = null) {
		if($fiche !== null) $this->fiches->add($fiche);
		return $this;
	}

	/**
	 * Supprime fiche
	 * @param fiche $fiche
	 * @return video
	 */
	public function removeFiche(fiche $fiche = null) {
		if($fiche !== null) $this->fiches->removeElement($fiche);
		return $this;
	}

	/**
	 * Renvoie fiches
	 * @return ArrayCollection 
	 */
	public function getFiches() {
		return $this->fiches;
	}

	/**
	 * Ajoute typeVideo
	 * @param typeVideo $typeVideo
	 * @return video
	 */
	public function addTypeVideo(typeVideo $typeVideo = null) {
		if($typeVideo !== null) $this->typeVideos->add($typeVideo);
		return $this;
	}

	/**
	 * Supprime typeVideo
	 * @param typeVideo $typeVideo
	 * @return video
	 */
	public function removeTypeVideo(typeVideo $typeVideo = null) {
		if($typeVideo !== null) $this->typeVideos->removeElement($typeVideo);
		return $this;
	}

	/**
	 * Renvoie typeVideos
	 * @return ArrayCollection 
	 */
	public function getTypeVideos() {
		return $this->typeVideos;
	}

	/**
	 * Set user
	 * @param User $user
	 * @return video
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
