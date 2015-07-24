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
// use laboBundle\Entity\interfaces\baseL2Interface;

/**
 * Entité pour gestion des unités (devises, mesures, etc.)
 * 
 * @ORM\MappedSuperclass
 */
abstract class baseValeur extends baseL1Entity {

	/**
	 * @var integer
	 * @ORM\Column(name="max", type="integer", nullable=false, unique=false)
	 */
	protected $max;

	/**
	 * @var integer
	 * @ORM\Column(name="min", type="integer", nullable=false, unique=false)
	 */
	protected $min;

	/**
	 * @var integer
	 * @ORM\Column(name="steps", type="integer", nullable=false, unique=false)
	 */
	protected $step;

	/**
	 * @var integer
	 * @ORM\Column(name="valeur", type="integer", nullable=false, unique=false)
	 */
	protected $valeur;

	/**
	 * @var array
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\LaboBundle\Entity\version")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $version;


	public function __construct() {
		parent::__construct();
		$this->max = 100;
		$this->min = 0;
		$this->step = 1;
		$this->valeur = 0;
	}

// DEBUT --------------------- à inclure dans toutes les entités ------------------------

	/**
	 * Renvoie true si l'entité est valide
	 * @return boolean
	 * @Assert\True(message = "Cette intervalle de valeurs n'est pas valide.")
	 */
	public function isValid() {
		$valid = true;
		$valid = parent::isValid();
		if($valid === true) {
			// opérations pour cette entité
			// …
			if($this->max <= $this->min) $valid = false;
			if($this->min >= $this->max) $valid = false;
			if($this->valeur > $this->max) $valid = false;
			if($this->valeur < $this->min) $valid = false;
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
			$this->controleValeur();
		}
		return $verif;
	}

// FIN --------------------- à inclure dans toutes les entités ------------------------

	public function controleValeur() {
		if($this->valeur > $this->max) $this->valeur = $this->max;
		if($this->valeur < $this->min) $this->valeur = $this->min;
	}

	/**
	 * Set max
	 * @param integer $max
	 * @return baseValeur
	 */
	public function setMax($max) {
		$this->max = $max;
		return $this;
	}

	/**
	 * Get max
	 * @return integer 
	 */
	public function getMax() {
		return $this->max;
	}

	/**
	 * Set min
	 * @param integer $min
	 * @return baseValeur
	 */
	public function setMin($min) {
		$this->min = $min;
		return $this;
	}

	/**
	 * Get min
	 * @return integer 
	 */
	public function getMin() {
		return $this->min;
	}

	/**
	 * Set step
	 * @param integer $step
	 * @return baseValeur
	 */
	public function setStep($step) {
		$this->step = $step;
		return $this;
	}

	/**
	 * Get step
	 * @return integer 
	 */
	public function getStep() {
		return $this->step;
	}

	/**
	 * incrémente et renvoie la valeur
	 * @param integer $valeur
	 * @return integer
	 */
	public function incValeur($valeur) {
		$this->valeur += $this->getStep();
		$this->controleValeur();
		return $this;
	}

	/**
	 * décrémente et renvoie la valeur
	 * @param integer $valeur
	 * @return integer
	 */
	public function decValeur($valeur) {
		$this->valeur -= $this->getStep();
		$this->controleValeur();
		return $this;
	}

	/**
	 * Set valeur
	 * @param integer $valeur
	 * @return baseValeur
	 */
	public function setValeur($valeur) {
		$this->valeur = $valeur;
		return $this;
	}

	/**
	 * Get valeur
	 * @return integer 
	 */
	public function getValeur() {
		return $this->valeur;
	}


	/**
	 * Set version
	 * @param version $version
	 * @return baseValeur
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