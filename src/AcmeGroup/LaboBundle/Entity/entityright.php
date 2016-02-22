<?php

namespace Acmegroup\LaboBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
// Slug
use Gedmo\Mapping\Annotation as Gedmo;
// Entities
use laboBundle\Entity\entityright as baseentityright;
use Acmegroup\LaboBundle\Entity\version;

/**
 * entityright
 *
 * @ORM\Entity
 * @ORM\Table(name="entityright")
 * @ORM\Entity(repositoryClass="Acmegroup\LaboBundle\Entity\entityrightRepository")
 * @UniqueEntity(fields={"nom", "version"}, message="Cette entityright existe déjà")
 */
class entityright extends baseentityright {

	/**
	 * @var integer
	 *
	 * @ORM\ManyToOne(targetEntity="Acmegroup\LaboBundle\Entity\version")
	 * @ORM\JoinColumn(nullable=false, unique=false)
	 */
	protected $version;

	public function __construct() {
		parent::__construct();
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
	 * @return entityright
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


}