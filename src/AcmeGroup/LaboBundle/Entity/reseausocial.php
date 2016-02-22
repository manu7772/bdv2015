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
use AcmeGroup\LaboBundle\Entity\typeReseau;

use \Exception;
use \DateTime;

/**
 * reseausocial
 * 
 * @ORM\Entity
 * @ORM\Table(name="reseausocial")
 * @ORM\Entity(repositoryClass="AcmeGroup\LaboBundle\Entity\reseausocialRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class reseausocial extends baseL2Entity {

	const DEFAULT_READ_RIGHT = 'ALL';
	const DEFAULT_WRITE_RIGHT = 'ROLE_EDITOR';
	const DEFAULT_DELETE_RIGHT = 'ROLE_EDITOR';

	/**
	 * @var string
	 * @ORM\Column(name="url", type="text", nullable=false, unique=false)
	 */
	protected $url;

	/**
	 * @var array
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\LaboBundle\Entity\typeReseau")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $typeReseau;

	/**
	 * @var array
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\LaboBundle\Entity\version", inversedBy="reseausocials")
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
	 * @Assert\True(message = "Ce reseau social n'est pas valide.")
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
			// if($this->nom === null) $this->nom = '';
		}
		return $verif;
	}

// FIN --------------------- à inclure dans toutes les entités ------------------------


	/**
	 * Définit url
	 * @param string $url
	 * @return reseausocial
	 */
	public function setUrl($url) {
		$this->url = $url;
		return $this;
	}

	/**
	 * Renvoie url
	 * @return string 
	 */
	public function getUrl() {
		return $this->url;
	}

	/**
	 * Définit typeReseau
	 * @param string $typeReseau
	 * @return reseausocial
	 */
	public function setTypeReseau(typeReseau $typeReseau = null) {
		$this->typeReseau = $typeReseau;
		return $this;
	}

	/**
	 * Renvoie typeReseau
	 * @return string 
	 */
	public function getTypeReseau() {
		return $this->typeReseau;
	}

	/**
	 * Définit propVersion
	 * @param version $propVersion
	 * @return reseausocial
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
