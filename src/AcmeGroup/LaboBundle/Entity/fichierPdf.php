<?php

namespace AcmeGroup\LaboBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
// slug/Tree
use Gedmo\Mapping\Annotation as Gedmo;
use AcmeGroup\LaboBundle\Entity\baseEntityPdf;
// Entities
use AcmeGroup\LaboBundle\Entity\article;
use AcmeGroup\LaboBundle\Entity\video;
use AcmeGroup\LaboBundle\Entity\statut;
use AcmeGroup\LaboBundle\Entity\version;
// User
use AcmeGroup\UserBundle\Entity\User;

use \Exception;
use \DateTime;

/**
 * fichierPdf
 *
 * @ORM\Entity
 * @ORM\Table(name="fichierPdf")
 * @ORM\Entity(repositoryClass="AcmeGroup\LaboBundle\Entity\fichierPdfRepository")
 */
class fichierPdf extends baseEntityPdf {

	const DEFAULT_READ_RIGHT = 'ALL';
	const DEFAULT_WRITE_RIGHT = 'ROLE_EDITOR';
	const DEFAULT_DELETE_RIGHT = 'ROLE_EDITOR';

	/**
	 * @var url
	 * @ORM\Column(name="url", type="text", nullable=true, unique=false)
	 */
	protected $url;

	/**
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\UserBundle\Entity\User", inversedBy="fichierPdfs")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $user;



	public function __construct() {
		parent::__construct();
		// attribution des droits
		$this->thisread = self::DEFAULT_READ_RIGHT;
		$this->thiswrite = self::DEFAULT_WRITE_RIGHT;
		$this->thisdelete = self::DEFAULT_DELETE_RIGHT;

		$this->articles = new ArrayCollection();
		$this->typefichierPdfs = new ArrayCollection();
	}


// DEBUT --------------------- à inclure dans toutes les entités ------------------------

	/**
	 * Renvoie true si l'entité est valide
	 * @Assert\True(message = "Cette fichierPdf n'est pas valide.")
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
	 * Set url
	 *
	 * @param string $url
	 * @return fichierPdf
	 */
	public function setUrl($url = null) {
		$this->url = $url;
		return $this;
	}

	/**
	 * Get url
	 *
	 * @return string 
	 */
	public function getUrl() {
		return $this->url;
	}

	/**
	 * Set user
	 * @param User $user
	 * @return fichierPdf
	 */
	public function setUser(User $user = null) {
		$this->user = $user;
		return $this;
	}

	/**
	 * Get user
	 * @return User 
	 */
	public function getUser() {
		return $this->user;
	}



}