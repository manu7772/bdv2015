<?php

namespace AcmeGroup\LaboBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
// slug/Tree
use Gedmo\Mapping\Annotation as Gedmo;
use AcmeGroup\LaboBundle\Entity\baseEntityImage;
// Entities
use AcmeGroup\LaboBundle\Entity\typeImage;
// User
use AcmeGroup\UserBundle\Entity\User;

use \Exception;
use \DateTime;

/**
 * image
 *
 * @ORM\Entity
 * @ORM\Table(name="image")
 * @ORM\Entity(repositoryClass="AcmeGroup\LaboBundle\Entity\imageRepository")
 */
class image extends baseEntityImage {

	/**
	 * @var url
	 * @ORM\Column(name="url", type="text", nullable=true, unique=false)
	 */
	protected $url;

	/**
	 * @ORM\ManyToMany(targetEntity="AcmeGroup\LaboBundle\Entity\typeImage")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $typeImages;

	/**
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\UserBundle\Entity\User", inversedBy="images")
	 * @ORM\JoinColumn(nullable=true, unique=true)
	 */
	protected $user;


	public function __construct() {
		parent::__construct();
		$this->typeImages = new ArrayCollection();
	}


// DEBUT --------------------- à inclure dans toutes les entités ------------------------

	/**
	 * Renvoie true si l'entité est valide
	 * @Assert\True(message = "Cette image n'est pas valide.")
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
	 * Set url
	 *
	 * @param string $url
	 * @return image
	 */
	public function setUrl($url = null) {
		$this->url = $url;
		return $this;
	}

	/**
	 * Get url
	 *
	 * @return string 
	 */
	public function getUrl() {
		return $this->url;
	}

	/**
	 * Ajoute typeImage
	 * @param typeImage $typeImage
	 * @return image
	 */
	public function addTypeImage(typeImage $typeImage = null) {
		$this->typeImages->add($typeImage);
		return $this;
	}

	/**
	 * Supprime typeImage
	 * @param typeImage $typeImage
	 * @return image
	 */
	public function removeTypeImage(typeImage $typeImage = null) {
		$this->typeImages->removeElement($typeImage);
		return $this;
	}

	/**
	 * Renvoie typeImages
	 * @return ArrayCollection 
	 */
	public function getTypeImages() {
		return $this->typeImages;
	}

	/**
	 * Set user
	 * @param User $user
	 * @return image
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