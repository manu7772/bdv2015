<?php

namespace AcmeGroup\LaboBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
// Slug
use Gedmo\Mapping\Annotation as Gedmo;
use AcmeGroup\LaboBundle\Entity\baseType;
use AcmeGroup\LaboBundle\Entity\collection;

use \Exception;
use \DateTime;

/**
 * typeCollection
 *
 * @ORM\Entity
 * @ORM\Table(name="typeCollection")
 * @ORM\Entity(repositoryClass="AcmeGroup\LaboBundle\Entity\typeCollectionRepository")
 * @UniqueEntity(fields={"nom", "version", "statut"}, message="Ce type de collection existe déjà")
 */
class typeCollection extends baseType {

	protected $typesMedia;

	public function __construct() {
		parent::__construct();
		$collection = new collection;
		$this->typesMedia = $collection->getTypesMedia();
	}

// DEBUT --------------------- à inclure dans toutes les entités ------------------------

	/**
	 * Renvoie true si l'entité est valide
	 * @Assert\True(message = "Cette collection n'est pas valide.")
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
	 * Renvoie les types de médias disponibles
	 * @return array
	 */
	public function getTypesMedia() {
		return $this->typesMedia;
	}

	/**
	 * Set nom
	 * @param string $nom
	 * @return typeCollection
	 */
	public function setNom($nom = null) {
		if(in_array($nom, $this->typesMedia) || $nom === null) parent::setNom($nom);
			else throw new Exception("Type de collection (\"".$nom."\") inconnu, parmi : NULL ou \"".implode('", "', $this->typesMedia)."\"", 1);
		return $this;
	}



}
