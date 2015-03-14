<?php

namespace AcmeGroup\LaboBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
// slug/Tree
use Gedmo\Mapping\Annotation as Gedmo;
use labo\Bundle\TestmanuBundle\Entity\paramBase;
// aeReponse
use labo\Bundle\TestmanuBundle\services\aetools\aeReponse;

/**
 * unite
 *
 * @ORM\Entity
 * @ORM\Table(name="unite")
 * @ORM\Entity(repositoryClass="AcmeGroup\LaboBundle\Entity\uniteRepository")
 * @UniqueEntity(fields={"nom"}, message="Cette unité existe déjà.")
 */
class unite extends paramBase {

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
	protected $lengtNomCourt;


	public function __construct() {
		parent::__construct();
		$this->lengtNomCourt = 3;
		$this->nomcourt = null;
	}

	/**
	 * @Assert/True(message = "Cette unité n'est pas valide.")
	 */
	public function isUniteValid() {
		return true;
	}

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function defineNomCourt() {
        if($this->nomcourt === null) $this->nomcourt = substr($this->nom, 0, $this->lengtNomCourt);
    }

	/**
	 * Set nomcourt
	 *
	 * @param string $nomcourt
	 * @return type
	 */
	public function setNomcourt($nomcourt = null) {
		if(is_string($nomcourt)) {
			$this->nomcourt = substr($nomcourt, 0, $this->lengtNomCourt);
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


}
