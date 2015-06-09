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
use AcmeGroup\UserBundle\Entity\User;
use AcmeGroup\LaboBundle\Entity\collection;
use AcmeGroup\LaboBundle\Entity\image;
use AcmeGroup\LaboBundle\Entity\tag;

use \Exception;
use \DateTime;

/**
 * pageweb
 * 
 * @ORM\Entity
 * @ORM\Table(name="pageweb")
 * @ORM\Entity(repositoryClass="AcmeGroup\LaboBundle\Entity\pagewebRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class pageweb extends baseL3EntityAttributs {

	/**
	 * @var string
	 * @ORM\Column(name="code", type="text", nullable=true, unique=false)
	 */
	protected $code;

	/**
	 * @var string
	 * @ORM\Column(name="title", type="string", length=100, nullable=true, unique=false)
	 */
	protected $title;

	/**
	 * @var string
	 * @ORM\Column(name="titreh1", type="string", length=255, nullable=true, unique=false)
	 */
	protected $titreh1;

	/**
	 * @var string
	 * @ORM\Column(name="metatitle", type="text", nullable=true, unique=false)
	 */
	protected $metatitle;

	/**
	 * @var string
	 * @ORM\Column(name="metadescription", type="text", nullable=true, unique=false)
	 */
	protected $metadescription;

	/**
	 * @var string
	 * @ORM\Column(name="fichierhtml", type="string", length=255, nullable=true, unique=false)
	 */
	protected $fichierhtml;

	/**
	 * @var string
	 * @ORM\Column(name="route", type="string", length=255)
	 */
	protected $route;

	/**
	 * @var array
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\LaboBundle\Entity\collection")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $diaporama;

	/**
	 * @var array
	 *
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\LaboBundle\Entity\image")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $firstmedia;

	/**
	 * @var array
	 *
	 * @ORM\ManyToMany(targetEntity="AcmeGroup\LaboBundle\Entity\image")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $medias;

	/**
	 * @var array
	 *
	 * @ORM\ManyToMany(targetEntity="AcmeGroup\LaboBundle\Entity\tag")
	 */
	protected $tags;


	public function __construct() {
		parent::__construct();
		$this->medias = new ArrayCollection();
		$this->tags = new ArrayCollection();
	}


// DEBUT --------------------- à inclure dans toutes les entités ------------------------

	/**
	 * Renvoie true si l'entité est valide
	 * @Assert\True(message = "Cet pageweb n'est pas valide.")
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
			if($this->nom === null) $this->nom = 'texte';
		}
		return $verif;
	}

// FIN --------------------- à inclure dans toutes les entités ------------------------


	/**
	 * Set code
	 *
	 * @param string $code
	 * @return pageweb
	 */
	public function setCode($code = null)
	{
		$this->code = $code;
	
		return $this;
	}

	/**
	 * Get code
	 *
	 * @return string 
	 */
	public function getCode()
	{
		return $this->code;
	}

	/**
	 * Set title
	 *
	 * @param string $title
	 * @return pageweb
	 */
	public function setTitle($title = null)
	{
		$this->title = $title;
	
		return $this;
	}

	/**
	 * Get title
	 *
	 * @return string 
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * Set titreh1
	 *
	 * @param string $titreh1
	 * @return pageweb
	 */
	public function setTitreh1($titreh1 = null)
	{
		$this->titreh1 = $titreh1;
	
		return $this;
	}

	/**
	 * Get titreh1
	 *
	 * @return string 
	 */
	public function getTitreh1()
	{
		return $this->titreh1;
	}

	/**
	 * Set metatitle
	 *
	 * @param string $metatitle
	 * @return pageweb
	 */
	public function setMetatitle($metatitle = null)
	{
		$this->metatitle = $metatitle;
	
		return $this;
	}

	/**
	 * Get metatitle
	 *
	 * @return string 
	 */
	public function getMetatitle()
	{
		return $this->metatitle;
	}

	/**
	 * Set metadescription
	 *
	 * @param string $metadescription
	 * @return pageweb
	 */
	public function setMetadescription($metadescription = null)
	{
		$this->metadescription = $metadescription;
	
		return $this;
	}

	/**
	 * Get metadescription
	 *
	 * @return string 
	 */
	public function getMetadescription()
	{
		return $this->metadescription;
	}

	/**
	 * Set fichierhtml
	 *
	 * @param string $fichierhtml
	 * @return pageweb
	 */
	public function setFichierhtml($fichierhtml = null)
	{
		$this->fichierhtml = $fichierhtml;
	
		return $this;
	}

	/**
	 * Get fichierhtml
	 *
	 * @return string 
	 */
	public function getFichierhtml()
	{
		return $this->fichierhtml;
	}

	/**
	 * Set route
	 *
	 * @param string $route
	 * @return pageweb
	 */
	public function setRoute($route)
	{
		$this->route = $route;
	
		return $this;
	}

	/**
	 * Get route
	 *
	 * @return string 
	 */
	public function getRoute()
	{
		return $this->route;
	}

	/**
	 * Set diaporama
	 *
	 * @param collection $diaporama
	 * @return baseEntity
	 */
	public function setDiaporama(collection $diaporama = null) {
		$this->diaporama = $diaporama;
		return $this;
	}

	/**
	 * Get diaporama
	 *
	 * @return collection
	 */
	public function getDiaporama() {
		return $this->diaporama;
	}

	/**
	 * Set firstmedia
	 *
	 * @param string $firstmedia
	 * @return pageweb
	 */
	public function setFirstmedia($firstmedia)
	{
		$this->firstmedia = $firstmedia;
	
		return $this;
	}

	/**
	 * Get firstmedia
	 *
	 * @return string 
	 */
	public function getFirstmedia()
	{
		return $this->firstmedia;
	}

	/**
	 * Add media
	 *
	 * @param image $image
	 * @return pageweb
	 */
	public function addMedia(image $image) {
		$this->medias[] = $image;
	
		return $this;
	}

	/**
	 * Remove media
	 *
	 * @param image $image
	 */
	public function removeMedia(image $image) {
		$this->medias->removeElement($image);
	}

	/**
	 * Get medias
	 *
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getMedias() {
		return $this->medias;
	}

	/**
	 * Add tag
	 *
	 * @param tag $tag
	 * @return pageweb
	 */
	public function addTag(tag $tag) {
		$this->tags->add($tag);
	
		return $this;
	}

	/**
	 * Remove tag
	 *
	 * @param tag $tag
	 */
	public function removeTag(tag $tag) {
		$this->tags->removeElement($tag);
	}

	/**
	 * Get tags
	 *
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getTags() {
		return $this->tags;
	}



}
