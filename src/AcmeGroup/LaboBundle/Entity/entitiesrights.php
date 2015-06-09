<?php

namespace Acmegroup\LaboBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
// Slug
use Gedmo\Mapping\Annotation as Gedmo;
// Entities
use laboBundle\Entity\entitiesrights as baseEntitiesrights;
use Acmegroup\LaboBundle\Entity\version;

/**
 * entitiesrights
 *
 * @ORM\Entity
 * @ORM\Table(name="entitiesrights")
 * @ORM\Entity(repositoryClass="Acmegroup\LaboBundle\Entity\entitiesrightsRepository")
 * @UniqueEntity(fields={"nom", "version"}, message="Cette entitiesrights existe déjà")
 */
class entitiesrights extends baseEntitiesrights {

	/**
	 * @var integer
	 *
	 * @ORM\ManyToOne(targetEntity="Acmegroup\LaboBundle\Entity\version")
	 * @ORM\JoinColumn(nullable=false, unique=false)
	 */
	protected $version;

	/**
	 * @var array
	 * @ORM\Column(name="globalreads", type="array", nullable=true, unique=false)
	 */
	protected $globalreads;
	/**
	 * @var array
	 * @ORM\Column(name="globalwrites", type="array", nullable=true, unique=false)
	 */
	protected $globalwrites;
	/**
	 * @var array
	 * @ORM\Column(name="globaldeletes", type="array", nullable=true, unique=false)
	 */
	protected $globaldeletes;

	public function __construct() {
		parent::__construct();
		$this->globalreads = new ArrayCollection;
		$this->globalwrites = new ArrayCollection;
		$this->globaldeletes = new ArrayCollection;
	}

// DEBUT --------------------- à inclure dans toutes les entités ------------------------

	/**
	 * Renvoie true si l'entité est valide
	 * @Assert\True(message = "Ce statut n'est pas valide.")
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
	 * Set version
	 *
	 * @param version $version
	 * @return entitiesrights
	 */
	public function setVersion(version $version) {
		$this->version = $version;
	
		return $this;
	}

	/**
	 * Get version
	 *
	 * @return version 
	 */
	public function getVersion() {
		return $this->version;
	}


	//// ENTITÉ GLOBALE /////

	/**
	 * Autorise les droit à $role : lecture sur cette entité GLOBALE
	 * @param string $role
	 * @return entitiesrights
	 */
	public function addGlobalread($role = null) {
		if($role !== null) ($this->globalreads[] = $role);
		return $this;
	}

	/**
	 * Supprime les droit à $role : lecture sur cette entité GLOBALE
	 * @param string $role
	 * @return entitiesrights
	 */
	public function removeGlobalread($role) {
		$this->globalreads->removeElement($role);
		return $this;
	}

	/**
	 * Renvoie les rôles ayant-droits : lecture sur cette entité GLOBALE
	 * @return ArrayCollection
	 */
	public function getGlobalreads() {
		return $this->globalreads;
	}

	/**
	 * Autorise les droit à $role : écriture sur cette entité GLOBALE
	 * @param string $role
	 * @return entitiesrights
	 */
	public function addGlobalwrite($role = null) {
		if($role !== null) ($this->globalwrites[] = $role);
		return $this;
	}

	/**
	 * Supprime les droit à $role : écriture sur cette entité GLOBALE
	 * @param string $role
	 * @return entitiesrights
	 */
	public function removeGlobalwrite($role) {
		$this->globalwrites->removeElement($role);
		return $this;
	}

	/**
	 * Renvoie les rôles ayant-droits : écriture sur cette entité GLOBALE
	 * @return ArrayCollection
	 */
	public function getGlobalwrites() {
		return $this->globalwrites;
	}

	/**
	 * Autorise les droit à $role : effacement sur cette entité GLOBALE
	 * @param string $role
	 * @return entitiesrights
	 */
	public function addGlobaldelete($role = null) {
		if($role !== null) ($this->globaldeletes[] = $role);
		return $this;
	}

	/**
	 * Supprime les droit à $role : effacement sur cette entité GLOBALE
	 * @param string $role
	 * @return entitiesrights
	 */
	public function removeGlobaldelete($role) {
		$this->globaldeletes->removeElement($role);
		return $this;
	}

	/**
	 * Renvoie les rôles ayant-droits : effacement sur cette entité GLOBALE
	 * @return ArrayCollection
	 */
	public function getGlobaldeletes() {
		return $this->globaldeletes;
	}


}