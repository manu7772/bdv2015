<?php

namespace AcmeGroup\LaboBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
// Slug
use Gedmo\Mapping\Annotation as Gedmo;
use AcmeGroup\LaboBundle\Entity\baseType;

use \Exception;
use \DateTime;

/**
 * tva
 *
 * @ORM\Entity
 * @ORM\Table(name="tva")
 * @ORM\Entity(repositoryClass="AcmeGroup\LaboBundle\Entity\tvaRepository")
 * @UniqueEntity(fields={"taux", "version", "statut"}, message="Ce type tva existe déjà")
 */
class tva extends baseType {

	const DEFAULT_READ_RIGHT = 'ALL';
	const DEFAULT_WRITE_RIGHT = 'ROLE_ADMIN';
	const DEFAULT_DELETE_RIGHT = 'ROLE_ADMIN';

	protected $nomlong;

	/**
	 * @var float
	 *
	 * @ORM\Column(name="taux", type="float", nullable=false, unique=false)
	 */
	protected $taux;

	/**
	 * @var float
	 *
	 * @ORM\Column(name="nouveauTaux", type="float", nullable=true, unique=false)
	 */
	protected $nouveauTaux;

	/**
	 * @var DateTime
	 *
	 * @ORM\Column(name="dateNouveauTaux", type="datetime", nullable=true)
	 */
	protected $dateNouveauTaux;


	public function __construct() {
		parent::__construct();
		// attribution des droits
		$this->thisread = self::DEFAULT_READ_RIGHT;
		$this->thiswrite = self::DEFAULT_WRITE_RIGHT;
		$this->thisdelete = self::DEFAULT_DELETE_RIGHT;

		$this->nouveauTaux = null;
		$this->dateNouveauTaux = null;
	}

// DEBUT --------------------- à inclure dans toutes les entités ------------------------

	/**
	 * Renvoie true si l'entité est valide
	 * @Assert\True(message = "Cette TVA n'est pas valide.")
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
			$this->verifTva();
		}
		return $verif;
	}

// FIN --------------------- à inclure dans toutes les entités ------------------------


	/**
	 * Applique le nouveau taux si la date est passée
	 * @return aeReponse
	 */
	public function verifTva() {
		// Vérification d'un nouveau taux planifié
		// application et remise à zéro
		if($this->getNouveauTaux() !== null && $this->getDateNouveauTaux() !== null) {
			$now = new DateTime();
			if($this->getDateNouveauTaux() <= $now) {
				$this->setTaux($this->getNouveauTaux());
				$this->setNouveauTaux(null);
				$this->setDateNouveauTaux(null);
			}
		}
		return $this;
	}

	/**
	 * Set nom long
	 * Si le nom n'est pas précisé, il est créé automatiquement
	 * utiliser '###nom###' et '###taux###' qui seront remplacés par les éléments voulus
	 *
	 * @param string $nomlong
	 * @param boolean $sens - 2 versions du texte long
	 * @return tva
	 */
	public function setNomlong($nomlong = null, $sens = true) {
		if($this->nomlong !== null) {
			$searchs = array('###nom###', '###taux###');
			$replacs = array($this->getNom(), $this->getTaux());
			$this->nomlong = trim($nomlong);
			$this->nomlong = str_replace($searchs, $replacs, $this->nomlong);
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
	public function setNouveauTaux($nouveauTaux = null) {
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
	 * Set dateNouveauTaux
	 *
	 * @param DateTime $dateNouveauTaux
	 * @return tva
	 */
	public function setDateNouveauTaux(DateTime $dateNouveauTaux = null) {
		$this->dateNouveauTaux = $dateNouveauTaux;
	
		return $this;
	}

	/**
	 * Get dateNouveauTaux
	 *
	 * @return DateTime 
	 */
	public function getDateNouveauTaux() {
		return $this->dateNouveauTaux;
	}

}
