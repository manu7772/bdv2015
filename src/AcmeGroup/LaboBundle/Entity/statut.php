<?php

namespace AcmeGroup\LaboBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
// Slug
use Gedmo\Mapping\Annotation as Gedmo;
use labo\Bundle\TestmanuBundle\Entity\paramBase;
// aeReponse
use labo\Bundle\TestmanuBundle\services\aetools\aeReponse;

/**
 * statut
 *
 * @ORM\Entity
 * @ORM\Table(name="statut")
 * @ORM\Entity(repositoryClass="AcmeGroup\LaboBundle\Entity\statutRepository")
 * @UniqueEntity(fields={"nom"}, message="Ce nom existe déjà.")
 */
class statut extends paramBase {

	public function __construct() {
		parent::__construct();
	}

	/**
	 * @Assert/True(message = "Ce statut n'est pas valide.")
	 */
	public function isStatutValid() {
		return true;
	}

}
