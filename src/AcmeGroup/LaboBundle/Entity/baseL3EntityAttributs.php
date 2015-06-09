<?php

namespace AcmeGroup\LaboBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use \DateTime;
use \Exception;
// Slug
use Gedmo\Mapping\Annotation as Gedmo;
// baseInterface
use laboBundle\Entity\baseAttributsEntity;
use laboBundle\Entity\interfaces\baseL2Interface;
// Entities
use AcmeGroup\LaboBundle\Entity\statut;
use AcmeGroup\LaboBundle\Entity\version;

/**
 * Entité de base L0 étendue => L1 pour gestion de dates (création / modification / expiration)
 * => ajout de gestion d'attributs
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks()
 */
abstract class baseL3EntityAttributs extends baseAttributsEntity implements baseL2Interface {

	/**
	 * @var array
	 * 
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\LaboBundle\Entity\statut")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $statut;

	/**
	 * @var array
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\LaboBundle\Entity\version")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $version;


	public function __construct() {
		parent::__construct();
	}

// DEBUT --------------------- à inclure dans toutes les entités ------------------------

	/**
	 * Renvoie true si l'entité est valide
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
	 * @return boolean
	 */
	public function verify() {
		$verif = true;
		$verif = parent::verify();
		if($verif === true) {
			// opérations pour cette entité
			// …
			if($this->statut instanceOf statut) $statutSlug = $this->statut->getSlug();
				else $statutSlug = "aucun";
			if($this->version instanceOf version) $versionSlug = $this->version->getSlug();
				else $versionSlug = "aucun";
			if(is_string($statutSlug)) $this->addToUniqueField('statut', $statutSlug);
			if(is_string($versionSlug)) $this->addToUniqueField('version', $versionSlug);
		}
		return $verif;
	}

// FIN --------------------- à inclure dans toutes les entités ------------------------


	/**
	 * Set statut
	 * @param statut $statut
	 * @return baseL2Entity
	 */
	public function setStatut($statut = null) {
		$this->statut = $statut;
		return $this;
	}

	/**
	 * Get statut
	 * @return statut 
	 */
	public function getStatut() {
		return $this->statut;
	}

	/**
	 * Set version
	 * @param version $version
	 * @return baseL2Entity
	 */
	public function setVersion($version = null) {
		$this->version = $version;
		return $this;
	}

	/**
	 * Get version
	 * @return version 
	 */
	public function getVersion() {
		return $this->version;
	}



}

