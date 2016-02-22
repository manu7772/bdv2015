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
use AcmeGroup\LaboBundle\Entity\image;
// User
use AcmeGroup\UserBundle\Entity\User;

use \Exception;
use \DateTime;

/**
 * evenement
 *
 * @ORM\Entity
 * @ORM\Table(name="evenement")
 * @ORM\Entity(repositoryClass="AcmeGroup\LaboBundle\Entity\evenementRepository")
 * @UniqueEntity(fields={"nom", "version", "statut"}, message="Cet evenement existe déjà.")
 */
class evenement extends baseL2Entity {

	const DEFAULT_READ_RIGHT = 'ALL';
	const DEFAULT_WRITE_RIGHT = 'ROLE_EDITOR';
	const DEFAULT_DELETE_RIGHT = 'ROLE_EDITOR';

	/**
	 * @var array
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\LaboBundle\Entity\image")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $image;

	/**
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\UserBundle\Entity\User", inversedBy="evenements")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $user;


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
	 * @Assert\True(message = "Cet evenement n'est pas valide.")
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
	 * Set image
	 *
	 * @param image $image
	 * @return evenement
	 */
	public function setImage(image $image = null) {
		$this->image = $image;
	
		return $this;
	}

	/**
	 * Get image
	 *
	 * @return image 
	 */
	public function getImage() {
		return $this->image;
	}

	/**
	 * Set user
	 * @param User $user
	 * @return evenement
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
