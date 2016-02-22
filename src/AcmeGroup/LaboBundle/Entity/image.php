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
 * @ORM\HasLifecycleCallbacks()
 */
class image extends baseEntityImage {

	const DEFAULT_READ_RIGHT = 'ALL';
	const DEFAULT_WRITE_RIGHT = 'ROLE_EDITOR';
	const DEFAULT_DELETE_RIGHT = 'ROLE_EDITOR';

	const TYPEDATA_DEFAULT = true;

	/**
	 * @var url
	 * @ORM\Column(name="url", type="text", nullable=true, unique=false)
	 */
	protected $url;

	/**
	 * @var boolean
	 * type de data : en BDD (true) ou fichier (false)
	 * @ORM\Column(name="typeData", type="boolean", nullable=false, unique=false)
	 */
	protected $typeData;

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

	/**
	 * image data (original)
	 * @ORM\OneToOne(targetEntity="AcmeGroup\LaboBundle\Entity\download", cascade={"persist", "remove"})
	 * @ORM\JoinColumn(nullable=true, unique=true)
	 */
	protected $data;

	/**
	 * image otpimized data (1024x1024 par ex.)
	 * @ORM\OneToOne(targetEntity="AcmeGroup\LaboBundle\Entity\download", cascade={"persist", "remove"})
	 * @ORM\JoinColumn(nullable=true, unique=true)
	 */
	protected $otpim;

	protected $upload_file;

	public function __construct() {
		parent::__construct();
		// attribution des droits
		$this->thisread = self::DEFAULT_READ_RIGHT;
		$this->thiswrite = self::DEFAULT_WRITE_RIGHT;
		$this->thisdelete = self::DEFAULT_DELETE_RIGHT;

		$this->typeImages = new ArrayCollection();
		$this->data = null;
		$this->otpim = null;
		$this->typeData = self::TYPEDATA_DEFAULT; // true : data / false : file
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
			if($this->isFile() && $this->getUrl() === null) $verif = false;
		}
		return $verif;
	}

// FIN --------------------- à inclure dans toutes les entités ------------------------

	public function __toString(){
		return $this->nom;
	}

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
	 * Set typeData
	 *
	 * @param boolean $typeData
	 * @return image
	 */
	public function setTypeData($typeData = null) {
		if($typeData !== (!self::TYPEDATA_DEFAULT)) $typeData = self::TYPEDATA_DEFAULT;
		$this->typeData = $typeData;
		return $this;
	}

	/**
	 * Get typeData
	 * @return boolean 
	 */
	public function getTypeData() {
		return $this->typeData;
	}

	/**
	 * définit l'image comme type fichier
	 * @return image
	 */
	public function setAsFile() {
		$this->setTypeData(false);
		return $this;
	}

	/**
	 * définit l'image comme type data (BDD)
	 * @return image
	 */
	public function setAsData() {
		$this->setTypeData(true);
	}

	/**
	 * l'image est de type fichier
	 * @return boolean
	 */
	public function isFile() {
		return !$this->typeData;
	}

	/**
	 * l'image est de type data (BDD)
	 * @return boolean
	 */
	public function isData() {
		return $this->typeData;
	}

	/**
	 * Ajoute typeImage
	 * @param typeImage $typeImage
	 * @return image
	 */
	public function addTypeImage(typeImage $typeImage = null) {
		if(is_object($typeImage)) $this->typeImages->add($typeImage);
		return $this;
	}

	/**
	 * Supprime typeImage
	 * @param typeImage $typeImage
	 * @return image
	 */
	public function removeTypeImage(typeImage $typeImage = null) {
		if(is_object($typeImage) && $this->typeImages->contains($typeImage))
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
		if($user !== null) $this->user = $user;
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