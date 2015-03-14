<?php

namespace AcmeGroup\LaboBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
// Slug
use Gedmo\Mapping\Annotation as Gedmo;
use labo\Bundle\TestmanuBundle\Entity\typeBase;
// Entities
use AcmeGroup\LaboBundle\Entity\image;
// aeReponse
use labo\Bundle\TestmanuBundle\services\aetools\aeReponse;

/**
 * cuisson
 *
 * @ORM\Entity
 * @ORM\Table(name="cuisson")
 * @ORM\Entity(repositoryClass="AcmeGroup\LaboBundle\Entity\cuissonRepository")
 * @UniqueEntity(fields={"nom"}, message="Cette cuisson existe déjà.")
 */
class cuisson extends typeBase {

	/**
	 * @var array
	 *
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\LaboBundle\Entity\image")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $image;

	public function __construct() {
		parent::__construct();
	}

	/**
	 * @Assert/True(message = "Cette cuisson n'est pas valide.")
	 */
	public function isCuissonValid() {
		return true;
	}

	/**
	 * Set image
	 *
	 * @param image $image
	 * @return article
	 */
	public function setImage(image $image = null) {
		$this->image = $image;
	
		return $this;
	}

	/**
	 * Get image
	 *
	 * @return image 
	 */
	public function getImage() {
		return $this->image;
	}

}
