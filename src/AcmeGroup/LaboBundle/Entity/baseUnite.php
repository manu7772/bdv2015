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
abstract class baseUnite extends baseL1Entity implements baseL2Interface {

	/**
	 * @var string
	 *
	 * @ORM\Column(name="nomcourt", type="string", length=3, nullable=true, unique=false)
	 * @Assert\NotBlank(message = "Vous devez remplir ce champ.")
	 * @Assert\Length(
	 *      min = "1",
	 *      max = "3",
	 *      minMessage = "Le nom court doit comporter au moins {{ limit }} lettres.",
	 *      maxMessage = "Le nom court doit comporter au maximum {{ limit }} lettres."
	 * )
	 */
	protected $nomcourt;

	// nombre de lettre max pour $nomcourt
	protected $lengthNomCourt;

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
			$this->defineNomCourt();
			$this->addToUniqueField('statut', $this->statut->getSlug());
			$this->addToUniqueField('version', $this->version->getSlug());
		}
		return $verif;
	}

// FIN --------------------- à inclure dans toutes les entités ------------------------


	/**
	 * Redéfinit le nom court de l'entité
	 * @return baseUnite
	 */
	public function defineNomCourt() {
		if($this->nomcourt === null || strlen(trim($this->nomcourt)) < 1) {
			$this->nomcourt = substr($this->nom, 0, $this->lengthNomCourt);
		}
		return $this;
	}

	/**
	 * Set nomcourt
	 *
	 * @param string $nomcourt
	 * @return baseUnite
	 */
	public function setNomcourt($nomcourt = null) {
		if(is_string($nomcourt)) {
			if (strlen(trim($nomcourt)) > 0) {
				$this->nomcourt = substr(trim($nomcourt), 0, $this->lengthNomCourt);
			} else $this->nomcourt = null;
		} else $this->nomcourt = null;
	
		return $this;
	}

	/**
	 * Get nomcourt
	 *
	 * @return string 
	 */
	public function getNomcourt() {
		return $this->nomcourt;
	}

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