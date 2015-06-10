<?php

namespace AcmeGroup\LaboBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
// Slug
use Gedmo\Mapping\Annotation as Gedmo;
// Base
use laboBundle\Entity\baseL1Entity;
use laboBundle\Entity\interfaces\baseL2Interface;

/**
 * Entité pour gestion des unités (devises, mesures, etc.)
 * 
 * @ORM\MappedSuperclass
 */
abstract class baseValeur extends baseL1Entity implements baseL2Interface {

	protected $max;
	protected $min;
	protected $steps;
	protected $valeur;

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
		$this->lengthNomCourt = 3;
		$this->nomcourt = null;
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
			$this->addToUniqueField('statut', $this->statut->getSlug());
			$this->addToUniqueField('version', $this->version->getSlug());
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