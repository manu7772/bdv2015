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
use AcmeGroup\LaboBundle\Entity\typeTelephone;
use AcmeGroup\LaboBundle\Entity\typeNatureTelephone;

use \Exception;
use \DateTime;

/**
 * telephone
 * 
 * @ORM\Entity
 * @ORM\Table(name="telephone")
 * @ORM\Entity(repositoryClass="AcmeGroup\LaboBundle\Entity\telephoneRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(fields={"nom", "version", "statut"}, message="Ce téléphone existe déjà")
 */
class telephone extends baseL2Entity {

	const DEFAULT_READ_RIGHT = 'ALL';
	const DEFAULT_WRITE_RIGHT = 'ROLE_ADMIN';
	const DEFAULT_DELETE_RIGHT = 'ROLE_ADMIN';

	/**
	 * @var string
	 * @ORM\Column(name="numero", type="string", length=14, nullable=false, unique=false)
	 */
	protected $numero;

	/**
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\LaboBundle\Entity\typeTelephone")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $typeTelephone;

	/**
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\LaboBundle\Entity\typeNatureTelephone")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $typeNatureTelephone;

	/**
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\UserBundle\Entity\User", inversedBy="telephones")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $user;

	/**
	 * @var array
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\LaboBundle\Entity\version", inversedBy="telephones")
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
	 * @Assert\True(message = "Ce telephone n'est pas valide.")
	 * @return boolean
	 */
	public function isValid() {
		$valid = true;
		$valid = parent::isValid();
		if($valid === true) {
			// opérations pour cette entité
			if(!preg_match("#^([0-9]{2}(\ |\.|-)?){4}[0-9]{2}$#", $this->numero)) $valid = false;
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
			$this->numero = str_replace($this->numberReplaces, $this->numberReplacesBy, $this->numero);
			if($this->nom === null) $this->nom = $this->numero;
		}
		return $verif;
	}

// FIN --------------------- à inclure dans toutes les entités ------------------------


	/**
	 * Définit numero
	 * @param string $numero
	 * @return numero
	 */
	public function setNumero($numero) {
		$this->numero = str_replace($this->numberReplaces, $this->numberReplacesBy, $numero);
		return $this;
	}

	/**
	 * Renvoie numero
	 * @return string 
	 */
	public function getNumero($spaces = true) {
		if($spaces !== false) {
			if(!is_string($spaces)) $spaces = $this->numberSpace;
			$result = 
				substr($this->numero, 0, 2).$spaces
				.substr($this->numero, 2, 2).$spaces
				.substr($this->numero, 4, 2).$spaces
				.substr($this->numero, 6, 2).$spaces
				.substr($this->numero, 8, 2);
		} else $result = $this->numero;
		return $this->numero;
	}

	/**
	 * Set typeTelephone -> nom du numéro de téléphone ("maison", "bureau", "service machin"…)
	 * @param typeTelephone $typeTelephone
	 * @return telephone
	 */
	public function setTypeTelephone(typeTelephone $typeTelephone = null) {
		$this->typeTelephone = $typeTelephone;
		return $this;
	}

	/**
	 * Get typeTelephone
	 * @return typeTelephone 
	 */
	public function getTypeTelephone() {
		return $this->typeTelephone;
	}

	/**
	 * Set typeNatureTelephone -> genre de numéro : mobile / télécopie / fixe…
	 * @param typeNatureTelephone $typeNatureTelephone
	 * @return telephone
	 */
	public function setTypeNatureTelephone(typeNatureTelephone $typeNatureTelephone = null) {
		$this->typeNatureTelephone = $typeNatureTelephone;
		return $this;
	}

	/**
	 * Get typeNatureTelephone
	 * @return typeNatureTelephone 
	 */
	public function getTypeNatureTelephone() {
		return $this->typeNatureTelephone;
	}

	/**
	 * Set user
	 * @param User $user
	 * @return telephone
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
	 * @return telephone
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
