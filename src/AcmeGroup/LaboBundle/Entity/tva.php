<?php

namespace AcmeGroup\LaboBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
// Slug
use Gedmo\Mapping\Annotation as Gedmo;
use labo\Bundle\TestmanuBundle\Entity\paramBase;
// Entities
use AcmeGroup\LaboBundle\Entity\statut;
use AcmeGroup\LaboBundle\Entity\version;
// aeReponse
use labo\Bundle\TestmanuBundle\services\aetools\aeReponse;

/**
 * tva
 *
 * @ORM\Entity
 * @ORM\Table(name="tva")
 * @ORM\Entity(repositoryClass="AcmeGroup\LaboBundle\Entity\tvaRepository")
 */
class tva extends paramBase {

	protected $nomlong;

	/**
	 * @var float
	 *
	 * @ORM\Column(name="taux", type="float", nullable=false, unique=true)
	 */
	protected $taux;

	/**
	 * @var float
	 *
	 * @ORM\Column(name="nouveauTaux", type="float", nullable=true, unique=false)
	 */
	protected $nouveauTaux;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="dateNouveauTaux", type="datetime", nullable=true)
	 */
	protected $dateNouveauTaux;

	/**
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\LaboBundle\Entity\statut" inversedBy="tvas")
	 * @ORM\JoinColumn(nullable=false, unique=false)
	 */
	protected $statut;

	/**
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\LaboBundle\Entity\version" inversedBy="tvas")
	 * @ORM\JoinColumn(nullable=false, unique=false)
	 */
	protected $version;


	public function __construct() {
		parent::__construct();
		$this->nouveauTaux = null;
		$this->dateNouveauTaux = null;
		// éléments requis pour la gestion de l'entité
		$this->addRequirements(array('User'));
	}

	/**
	 * @Assert/True(message = "Cette TVA n'est pas valide.")
	 */
	public function isTvaValid() {
		return true;
	}

	/**
	 * Vérifie l'entité. 
	 * Nom formalisé : "verif" + Nom_de_l_entité (avec maj.)
	 * @return aeReponse
	 */
	public function verifTva() {
		$aeReponse = new aeReponse();
		if($this->requirementsComplete === true) {
			// Vérification d'un nouveau taux planifié
			// application et remise à zéro
			if($this->getNouveauTaux() !== null && $this->getDateNouveauTaux() !== null) {
				$now = new \Datetime();
				if($this->getDateNouveauTaux() <= $now) {
					$this->setTaux($this->getNouveauTaux());
					$this->setNouveauTaux(null);
					$this->setDateNouveauTaux(null);
				}
			}
			// Autres vérifications…
			// Ci-dessous…
		} else $aeReponse->setUnvalid();
		return $aeReponse;
	}

	/**
	 * Set nom
	 *
	 * @param string $nom
	 * @return tva
	 */
	public function setNom($nom) {
		$this->nom = trim($nom);
	
		return $this;
	}

	/**
	 * Get nom
	 *
	 * @return string 
	 */
	public function getNom() {
		return $this->nom;
	}

	/**
	 * Set nom long
	 * Si le nom n'est pas précisé, il est créé automatiquement
	 *
	 * @param string $nomlong
	 * @param boolean $sens - 2 versions du texte long
	 * @return tva
	 */
	public function setNomlong($nomlong = null, $sens = true) {
		if($this->nomlong !== null) {
			$this->nomlong = trim($nomlong);
		} else {
			if($sens === true) $this->nomlong = $this->getTaux(). "% (".$this->getNom().")";
				else $this->nomlong = $this->getNom(). " (".$this->getTaux()." %)";
		}
		return $this;
	}

	/**
	 * Get nom long
	 * 
	 * @param boolean $sens - 2 versions du texte long
	 * @return string 
	 */
	public function getNomlong($sens = true) {
		if($this->nomlong === null) $this->setNomlong(null, $sens);
		return $this->nomlong;
	}

	/**
	 * Set taux
	 *
	 * @param float $taux
	 * @return tva
	 */
	public function setTaux($taux) {
		$this->taux = $taux;
	
		return $this;
	}

	/**
	 * Get taux
	 *
	 * @return float 
	 */
	public function getTaux() {
		return $this->taux;
	}

	/**
	 * Set nouveauTaux
	 *
	 * @param float $nouveauTaux
	 * @return tva
	 */
	public function setNouveauTaux($nouveauTaux) {
		$this->nouveauTaux = $nouveauTaux;
	
		return $this;
	}

	/**
	 * Get nouveauTaux
	 *
	 * @return float 
	 */
	public function getNouveauTaux() {
		return $this->nouveauTaux;
	}

	/**
	 * Set dateExpiration
	 *
	 * @param \DateTime $dateExpiration
	 * @return tva
	 */
	public function setDateExpiration($dateExpiration) {
		$this->dateExpiration = $dateExpiration;
	
		return $this;
	}

	/**
	 * Get dateExpiration
	 *
	 * @return \DateTime 
	 */
	public function getDateExpiration() {
		return $this->dateExpiration;
	}

	/**
	 * Set dateNouveauTaux
	 *
	 * @param \DateTime $dateNouveauTaux
	 * @return tva
	 */
	public function setDateNouveauTaux($dateNouveauTaux = null) {
		$this->dateNouveauTaux = $dateNouveauTaux;
	
		return $this;
	}

	/**
	 * Get dateNouveauTaux
	 *
	 * @return \DateTime 
	 */
	public function getDateNouveauTaux() {
		return $this->dateNouveauTaux;
	}

	/**
	 * Set statut
	 *
	 * @param statut $statut
	 * @return tva
	 */
	public function setStatut(statut $statut) {
		$this->statut = $statut;
	
		return $this;
	}

	/**
	 * Get statut
	 *
	 * @return statut 
	 */
	public function getStatut() {
		return $this->statut;
	}

	/**
	 * Set version
	 *
	 * @param version $version
	 * @return tva
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
