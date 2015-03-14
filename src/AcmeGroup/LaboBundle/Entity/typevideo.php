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
 * typevideo
 *
 * @ORM\Entity
 * @ORM\Table(name="typevideo")
 * @ORM\Entity(repositoryClass="AcmeGroup\LaboBundle\Entity\typevideoRepository")
 * @UniqueEntity(fields={"nom"}, message="Ce nom existe déjà.")
 */
class typevideo extends paramBase {

	public function __construct() {
		parent::__construct();
	}

	/**
	 * @Assert/True(message = "Ce type de fiche n'est pas valide.")
	 */
	public function isTypevideoValid() {
		return true;
	}

}
