<?php

namespace AcmeGroup\LaboBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
// Slug
use Gedmo\Mapping\Annotation as Gedmo;
use AcmeGroup\LaboBundle\Entity\baseType;
// Entities
use AcmeGroup\LaboBundle\Entity\image;
use AcmeGroup\LaboBundle\Entity\typeFiche;
// User
use AcmeGroup\UserBundle\Entity\User;

use \Exception;
use \DateTime;

/**
 * fiche
 *
 * @ORM\Entity
 * @ORM\Table(name="fiche")
 * @ORM\Entity(repositoryClass="AcmeGroup\LaboBundle\Entity\ficheRepository")
 * @UniqueEntity(fields={"nom", "version", "statut"}, message="Cette fiche existe déjà.")
 */
class fiche extends baseType {

	/**
	 * @var array
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\LaboBundle\Entity\image")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $image;

	/**
	 * @ORM\ManyToMany(targetEntity="AcmeGroup\LaboBundle\Entity\typeFiche")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $typeFiches;

	/**
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\UserBundle\Entity\User", inversedBy="fiches")
	 * @ORM\JoinColumn(nullable=true, unique=true)
	 */
	protected $user;

	/**
	 * @ORM\ManyToMany(targetEntity="AcmeGroup\LaboBundle\Entity\article", mappedBy="fiches")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $articles;


	public function __construct() {
		parent::__construct();
		$this->articles = new ArrayCollection();
		$this->typeFiches = new ArrayCollection();
	}


// DEBUT --------------------- à inclure dans toutes les entités ------------------------

	/**
	 * Renvoie true si l'entité est valide
	 * @Assert\True(message = "Cette fiche n'est pas valide.")
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
	 * Set image
	 *
	 * @param image $image
	 * @return fiche
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

	/**
	 * Ajoute typeFiche
	 * @param typeFiche $typeFiche
	 * @return image
	 */
	public function addTypeFiche(typeFiche $typeFiche = null) {
		$this->typeFiches->add($typeFiche);
		return $this;
	}

	/**
	 * Supprime typeFiche
	 * @param typeFiche $typeFiche
	 * @return image
	 */
	public function removeTypeFiche(typeFiche $typeFiche = null) {
		$this->typeFiches->removeElement($typeFiche);
		return $this;
	}

	/**
	 * Renvoie typeFiches
	 * @return ArrayCollection 
	 */
	public function getTypeFiches() {
		return $this->typeFiches;
	}

	/**
	 * Set user
	 * @param User $user
	 * @return fiche
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

	/**
	 * Ajoute article
	 * @param article $article
	 * @return fiche
	 */
	public function addArticle(article $article = null) {
		$this->articles->add($article);
		return $this;
	}

	/**
	 * Supprime article
	 * @param article $article
	 * @return fiche
	 */
	public function removeArticle(article $article = null) {
		$this->articles->removeElement($article);
		return $this;
	}

	/**
	 * Renvoie articles
	 * @return ArrayCollection 
	 */
	public function getArticles() {
		return $this->articles;
	}


}
