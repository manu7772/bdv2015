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
 * typeNatureTelephone
 *
 * @ORM\Entity
 * @ORM\Table(name="typeNatureTelephone")
 * @ORM\Entity(repositoryClass="AcmeGroup\LaboBundle\Entity\typeNatureTelephoneRepository")
 * @UniqueEntity(fields={"nom", "version", "statut"}, message="Ce type de nature de téléphone existe déjà")
 */
class typeNatureTelephone extends baseType {


	public function __construct() {
		parent::__construct();
	}

// DEBUT --------------------- à inclure dans toutes les entités ------------------------

	/**
	 * Renvoie true si l'entité est valide
	 * @Assert\True(message = "Ce type de nature de téléphone n'est pas valide.")
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


}
