<?php

namespace AcmeGroup\LaboBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
// Slug
use Gedmo\Mapping\Annotation as Gedmo;
use laboBundle\Entity\version as baseVersion;
// Entities
use AcmeGroup\LaboBundle\Entity\reseausocial;
use AcmeGroup\LaboBundle\Entity\telephone;
use AcmeGroup\LaboBundle\Entity\image;
use AcmeGroup\LaboBundle\Entity\adresse;
use AcmeGroup\UserBundle\Entity\User;

/**
 * version
 *
 * @ORM\Entity
 * @ORM\Table(name="version")
 * @ORM\Entity(repositoryClass="AcmeGroup\LaboBundle\Entity\versionRepository")
 * @UniqueEntity(fields={"siren"}, message="Cette version existe déjà")
 */
class version extends baseVersion {

	/**
	 * @var array
	 * @ORM\OneToMany(targetEntity="AcmeGroup\LaboBundle\Entity\reseausocial", mappedBy="propVersion", cascade={"all"})
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 * @Assert\Valid()
	 */
	protected $reseausocials;

	/**
	 * @var array
	 * @ORM\OneToMany(targetEntity="AcmeGroup\LaboBundle\Entity\telephone", mappedBy="propVersion", cascade={"all"})
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 * @Assert\Valid()
	 */
	protected $telephones;

	/**
	 * @var integer
	 * @ORM\OneToOne(targetEntity="AcmeGroup\LaboBundle\Entity\image", cascade={"all"})
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 * @Assert\Valid()
	 */
	protected $logo;

	/**
	 * @var integer
	 * @ORM\OneToOne(targetEntity="AcmeGroup\LaboBundle\Entity\image", cascade={"all"})
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 * @Assert\Valid()
	 */
	protected $favicon;

	/**
	 * @var integer
	 * @ORM\OneToOne(targetEntity="AcmeGroup\LaboBundle\Entity\image", cascade={"all"})
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 * @Assert\Valid()
	 */
	protected $imageEntete;

	/**
	 * @var string
	 * @ORM\OneToMany(targetEntity="AcmeGroup\LaboBundle\Entity\adresse", mappedBy="propVersion", cascade={"all"})
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 * @Assert\Valid()
	 */
	protected $adresses;

	/**
	 * @var array
	 * @ORM\OneToMany(targetEntity="AcmeGroup\UserBundle\Entity\User", mappedBy="version")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $users;

	public function __construct() {
		parent::__construct();
		$this->reseausocials	= new ArrayCollection;
		$this->telephones		= new ArrayCollection;
		$this->adresses			= new ArrayCollection;
		$this->users 			= new ArrayCollection;
	}

// DEBUT --------------------- à inclure dans toutes les entités ------------------------

	/**
	 * Renvoie true si l'entité est valide
	 * @Assert\True(message = "Cette version n'est pas valide.")
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
	 * Ajoute un réseau social
	 * @param reseausocial $reseausocial
	 * @return version
	 */
	public function addReseausocial(reseausocial $reseausocial = null) {
		if($reseausocial !== null) {
			$this->reseausocials->add($reseausocial);
		}
		return $this;
	}

	/**
	 * Ajoute un réseau social
	 * @param reseausocial $reseausocial
	 * @return version
	 */
	public function removeReseausocial(reseausocial $reseausocial) {
		$this->reseausocials->removeElement($reseausocial);
		return $this;
	}

	/**
	 * Renvoie les réseaux sociaux
	 * @return array 
	 */
	public function getReseausocials() {
		return $this->reseausocials;
	}

	/**
	 * Add telephone
	 * @param telephone $telephone
	 * @return version
	 */
	public function addTelephone(telephone $telephone = null) {
		if($telephone !== null) {
			$this->telephones->add($telephone);
		}
		return $this;
	}

	/**
	 * Remove telephone
	 * @param telephone $telephone
	 * @return version 
	 */
	public function removeTelephone(telephone $telephone) {
		$this->telephones->removeElement($telephone);
		return $this;
	}

	/**
	 * Get telephones
	 * @return array 
	 */
	public function getTelephones() {
		return $this->telephones;
	}

	/**
	 * Add email
	 * @param email $email
	 * @return version
	 */
	public function addEmail(email $email = null) {
		if($email !== null) {
			$this->emails->add($email);
		}
		return $this;
	}

	/**
	 * Remove email
	 * @return version 
	 */
	public function removeEmail($email) {
		$this->emails->removeElement($email);
		return $this;
	}

	/**
	 * Get emails
	 * @return array 
	 */
	public function getEmails() {
		return $this->emails;
	}

	/**
	 * Set logo
	 * @param image $logo
	 * @return version
	 */
	public function setLogo(image $logo = null) {
		$this->logo = $logo;
		return $this;
	}

	/**
	 * Get logo
	 * @return image 
	 */
	public function getLogo() {
		return $this->logo;
	}

	/**
	 * Set favicon
	 * @param image $favicon
	 * @return version
	 */
	public function setFavicon(image $favicon = null) {
		$this->favicon = $favicon;
		return $this;
	}

	/**
	 * Get favicon
	 * @return image 
	 */
	public function getFavicon() {
		return $this->favicon;
	}

	/**
	 * Set imageEntete
	 * @param image $imageEntete
	 * @return version
	 */
	public function setImageEntete(image $imageEntete = null) {
		$this->imageEntete = $imageEntete;
		return $this;
	}

	/**
	 * Get imageEntete
	 * @return image 
	 */
	public function getImageEntete() {
		return $this->imageEntete;
	}

	/**
	 * Add adresse
	 * @param adresse $adresse
	 * @return version
	 */
	public function addAdresse(adresse $adresse = null) {
		if($adresse !== null) {
			$this->adresses->add($adresse);
			$adresse->setVersion($this);
		}
		return $this;
	}

	/**
	 * Remove adresse
	 * @param adresse $adresse
	 * @return version
	 */
	public function removeAdresse(adresse $adresse) {
		$this->adresses->removeElement($adresse);
		$adresse->setVersion(null);
		return $this;
	}

	/**
	 * Get adresses
	 * @return array 
	 */
	public function getAdresses() {
		return $this->adresses;
	}

	/**
	 * Add user
	 * @param user $user
	 * @return version
	 */
	public function addUser(user $user = null) {
		if($user !== null) {
			$this->users->add($user);
			$user->setVersion($this);
		}
		return $this;
	}

	/**
	 * Remove user
	 * @param user $user
	 * @return version
	 */
	public function removeUser(user $user) {
		$this->users->removeElement($user);
		// $user->setVersion(null);
		return $this;
	}

	/**
	 * Get users
	 * @return array 
	 */
	public function getUsers() {
		return $this->users;
	}

}