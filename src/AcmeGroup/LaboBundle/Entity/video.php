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
use AcmeGroup\LaboBundle\Entity\article;
use AcmeGroup\LaboBundle\Entity\version;
use AcmeGroup\LaboBundle\Entity\fiche;
// User
use AcmeGroup\UserBundle\Entity\User;
// aeReponse
use labo\Bundle\TestmanuBundle\services\aetools\aeReponse;

/**
 * video
 *
 * @ORM\Entity
 * @ORM\Table(name="video")
 * @ORM\Entity(repositoryClass="AcmeGroup\LaboBundle\Entity\videoRepository")
 */
class video extends entityBase {

	/**
	 * @var string
	 *
	 * @ORM\Column(name="descriptif", type="text", nullable=true, unique=false)
	 */
	protected $descriptif;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="videoUrl", type="text")
	 */
	protected $videoUrl;

	/**
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\LaboBundle\Entity\statut")
	 * @ORM\JoinColumn(nullable=false, unique=false)
	 */
	protected $statut;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="datePublication", type="datetime", nullable=false)
	 */
	protected $datePublication;

	/**
	 * @var array
	 *
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\LaboBundle\Entity\version", inversedBy="videos")
	 * @ORM\JoinColumn(nullable=false, unique=false)
	 */
	protected $version;

	/**
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\UserBundle\Entity\User", inversedBy="videos")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $user;

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


	public function __construct() {
		parent::__construct();
		$this->datePublication = new \Datetime();
		$this->articles = new ArrayCollection();
		$this->fiches = new ArrayCollection();
	}

	/**
	 * @Assert/True(message = "Cette vidéo n'est pas valide.")
	 */
	public function isVideoValid() {
		return true;
	}


	/**
	 * Set descriptif
	 *
	 * @param string $descriptif
	 * @return video
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
	 * Set videoUrl
	 *
	 * @param string $videoUrl
	 * @return video
	 */
	public function setVideoUrl($videoUrl) {
		// $this->videoUrl = $videoUrl;
		$this->videoUrl = preg_replace('#^(((http|https)(://)(.+))/)?(.+)$#', '$6', $videoUrl);
		return $this;
	}

	/**
	 * Get videoUrl
	 *
	 * @return string 
	 */
	public function getVideoUrl() {
		return $this->videoUrl;
	}

	/**
	 * Set statut
	 *
	 * @param statut $statut
	 * @return video
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
	 * Set datePublication
	 *
	 * @param \DateTime $datePublication
	 * @return video
	 */
	public function setDatePublication($datePublication) {
		$this->datePublication = $datePublication;
	
		return $this;
	}

	/**
	 * Get datePublication
	 *
	 * @return \DateTime 
	 */
	public function getDatePublication() {
		return $this->datePublication;
	}

	/**
	 * Set slug
	 *
	 * @param integer $slug
	 * @return video
	 */
	public function setSlug($slug) {
		$this->slug = $slug;
		return $this;
	}    

	/**
	 * Get slug
	 *
	 * @return string
	 */
	public function getSlug() {
		return $this->slug;
	}

	/**
	 * Set propUser
	 *
	 * @param User $propUser
	 * @return video
	 */
	public function setPropUser(User $propUser = null) {
		$this->propUser = $propUser;
	
		return $this;
	}

	/**
	 * Get propUser
	 *
	 * @return User 
	 */
	public function getPropUser() {
		return $this->propUser;
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
	 * Add article
	 *
	 * @param article $article
	 * @return video
	 */
	public function addArticle(article $article = null) {
		$this->articles[] = $article;
	
		return $this;
	}

	/**
	 * Remove article
	 *
	 * @param article $article
	 */
	public function removeArticle(article $article = null) {
		$this->articles->removeElement($article);
	}

}
