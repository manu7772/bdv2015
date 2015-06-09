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
use AcmeGroup\LaboBundle\Entity\tag;

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
	 * @var integer
	 *
	 * @ORM\Column(name="vitesse", type="integer", nullable=false)
	 */
	protected $vitesse;

	/**
	 * @var array
	 *
	 * @ORM\ManyToMany(targetEntity="AcmeGroup\LaboBundle\Entity\tag")
	 */
	protected $tags;


	public function __construct() {
		parent::__construct();
		$this->firstmedia = null;
		$this->medias = new ArrayCollection();
		$this->vitesse = 5000;
		$this->tags = new ArrayCollection();
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
	 * Set firstmedia
	 *
	 * @param string $firstmedia
	 * @return collection
	 */
	public function setFirstmedia($firstmedia) {
		$this->firstmedia = $firstmedia;
		return $this;
	}

	/**
	 * Get firstmedia
	 *
	 * @return string 
	 */
	public function getFirstmedia() {
		return $this->firstmedia;
	}

	/**
	 * Add media
	 *
	 * @param image $image
	 * @return collection
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
	 * Add tag
	 *
	 * @param tag $tag
	 * @return collection
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
