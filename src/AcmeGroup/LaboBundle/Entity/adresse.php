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
use AcmeGroup\LaboBundle\Entity\typeAdresse;

use \Exception;
use \DateTime;

/**
 * adresse
 * 
 * @ORM\Entity
 * @ORM\Table(name="adresse")
 * @ORM\Entity(repositoryClass="AcmeGroup\LaboBundle\Entity\adresseRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class adresse extends baseL2Entity {

	const DEFAULT_READ_RIGHT = 'ALL';
	const DEFAULT_WRITE_RIGHT = 'ROLE_ADMIN';
	const DEFAULT_DELETE_RIGHT = 'ROLE_ADMIN';

	/**
	 * @var string
	 * @ORM\Column(name="adresse", type="text", nullable=true, unique=false)
	 */
	protected $adresse;

	/**
	 * @var string
	 * @ORM\Column(name="cp", type="string", length=5, nullable=true, unique=false)
	 */
	protected $cp;

	/**
	 * @var string
	 * @ORM\Column(name="ville", type="string", length=100, nullable=true, unique=false)
	 */
	protected $ville;

	/**
	 * @var string
	 * @ORM\Column(name="commentaire", type="text", nullable=true, unique=false)
	 */
	protected $commentaire;

	/**
	 * @ORM\OneToOne(targetEntity="AcmeGroup\LaboBundle\Entity\typeAdresse")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $typeAdresse;

	/**
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\UserBundle\Entity\User", inversedBy="adresses")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $user;

	/**
	 * @var array
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\LaboBundle\Entity\version", inversedBy="adresses")
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
	 * @Assert\True(message = "Cette adresse n'est pas valide.")
	 * @return boolean
	 */
	public function isValid() {
		$valid = true;
		$valid = parent::isValid();
		if($valid === true) {
			// opérations pour cette entité
			if($this->cp !== null) {
				if(!preg_match('#^[0-9]{5}$#', $this->cp)) $valid = false;
			}
			// tous champs vides = invalide
			if($this->adresse === null && $this->cp === null && $this->ville === null && $this->commentaire === null) {
				$valid = false;
			}
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
			$this->cp = $this->normalizeCp($this->cp);
		}
		return $verif;
	}

// FIN --------------------- à inclure dans toutes les entités ------------------------

	/**
	 * Définit adresse
	 * @param string $adresse
	 * @return adresse
	 */
	public function setAdresse($adresse) {
		$this->adresse = $adresse;
		return $this;
	}

	/**
	 * Renvoie adresse
	 * @return string 
	 */
	public function getAdresse() {
		return $this->adresse;
	}

	/**
	 * Définit cp
	 * @param string $cp
	 * @return cp
	 */
	public function setCp($cp = null) {
		$this->cp = $cp;
		return $this;
	}

	/**
	 * Renvoie cp
	 * @return string 
	 */
	public function getCp() {
		return $this->cp;
	}

	/**
	 * Définit ville
	 * @param string $ville
	 * @return ville
	 */
	public function setVille($ville = null) {
		$this->ville = $ville;
		return $this;
	}

	/**
	 * Renvoie ville
	 * @return string 
	 */
	public function getVille() {
		return $this->ville;
	}

	/**
	 * Définit commentaire
	 * @param string $commentaire
	 * @return commentaire
	 */
	public function setCommentaire($commentaire = null) {
		$this->commentaire = $commentaire;
		return $this;
	}

	/**
	 * Renvoie commentaire
	 * @return string 
	 */
	public function getCommentaire() {
		return $this->commentaire;
	}

	/**
	 * Set typeAdresse
	 * @param typeAdresse $typeAdresse
	 * @return email
	 */
	public function setTypeAdresse(typeAdresse $typeAdresse = null) {
		$this->typeAdresse = $typeAdresse;
		return $this;
	}

	/**
	 * Get typeAdresse
	 * @return typeAdresse 
	 */
	public function getTypeAdresse() {
		return $this->typeAdresse;
	}

	/**
	 * Définit user
	 * @param user $user
	 * @return adresse
	 */
	public function setUser(User $user = null) {
		$this->user = $user;
		return $this;
	}

	/**
	 * Renvoie user
	 * @return user 
	 */
	public function getUser() {
		return $this->user;
	}

	/**
	 * Définit propVersion
	 * @param version $propVersion
	 * @return adresse
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
