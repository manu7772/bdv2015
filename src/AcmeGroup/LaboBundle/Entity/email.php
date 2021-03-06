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
use AcmeGroup\UserBundle\Entity\User;
use AcmeGroup\LaboBundle\Entity\typeemail;

use \Exception;
use \DateTime;

/**
 * email
 * 
 * @ORM\Entity
 * @ORM\Table(name="email")
 * @ORM\Entity(repositoryClass="AcmeGroup\LaboBundle\Entity\emailRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class email extends baseL2Entity {

	const DEFAULT_READ_RIGHT = 'ALL';
	const DEFAULT_WRITE_RIGHT = 'ROLE_ADMIN';
	const DEFAULT_DELETE_RIGHT = 'ROLE_ADMIN';

	/**
	 * @var string
	 * @ORM\Column(name="email", type="string", nullable=false, unique=false)
	 * @Assert\Email(message = "Vous devez indiquer un email valide et complet.")
	 */
	protected $email;

	/**
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\LaboBundle\Entity\typeEmail")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $typeEmail;

	/**
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\UserBundle\Entity\User", inversedBy="autremails")
	 * @ORM\JoinColumn(nullable=true, unique=true)
	 */
	protected $user;

	/**
	 * @var array
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\LaboBundle\Entity\version", inversedBy="emails")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $propVersion;


	public function __construct() {
		parent::__construct();
		// attribution des droits
		$this->thisread = self::DEFAULT_READ_RIGHT;
		$this->thiswrite = self::DEFAULT_WRITE_RIGHT;
		$this->thisdelete = self::DEFAULT_DELETE_RIGHT;

	}


// DEBUT --------------------- à inclure dans toutes les entités ------------------------

	/**
	 * Renvoie true si l'entité est valide
	 * @Assert\True(message = "Cet email n'est pas valide.")
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
			if($this->nom === null) $this->nom = $this->email;
		}
		return $verif;
	}

// FIN --------------------- à inclure dans toutes les entités ------------------------


	/**
	 * Définit email
	 * @param string $email
	 * @return email
	 */
	public function setEmail($email) {
		$this->email = $email;
		return $this;
	}

	/**
	 * Renvoie email
	 * @return string 
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * Set typeEmail
	 * @param typeEmail $typeEmail
	 * @return email
	 */
	public function setTypeEmail(typeEmail $typeEmail = null) {
		$this->typeEmail = $typeEmail;
	
		return $this;
	}

	/**
	 * Get typeEmail
	 * @return typeEmail 
	 */
	public function getTypeEmail() {
		return $this->typeEmail;
	}

	/**
	 * Set user
	 * @param User $user
	 * @return email
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
	 * Définit propVersion
	 * @param version $propVersion
	 * @return email
	 */
	public function setPropVersion(version $propVersion = null) {
		$this->propVersion = $propVersion;
		return $this;
	}

	/**
	 * Renvoie propVersion
	 * @return version 
	 */
	public function getPropVersion() {
		return $this->propVersion;
	}


}
