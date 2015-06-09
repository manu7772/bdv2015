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
use AcmeGroup\LaboBundle\Entity\article;

use \Exception;
use \DateTime;

/**
 * cuisson
 *
 * @ORM\Entity
 * @ORM\Table(name="cuisson")
 * @ORM\Entity(repositoryClass="AcmeGroup\LaboBundle\Entity\cuissonRepository")
 * @UniqueEntity(fields={"nom", "version", "statut"}, message="Cette cuisson existe déjà.")
 */
class cuisson extends baseType {

	/**
	 * @var array
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\LaboBundle\Entity\image")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $image;

	/**
	 * @var array
	 * 
	 * @ORM\ManyToMany(targetEntity="AcmeGroup\LaboBundle\Entity\article", mappedBy="cuissons")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $articles;

	public function __construct() {
		parent::__construct();
		$this->articles = new ArrayCollection;
	}


// DEBUT --------------------- à inclure dans toutes les entités ------------------------

	/**
	 * Renvoie true si l'entité est valide
	 * @Assert\True(message = "Cette cuisson n'est pas valide.")
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
	 * @return cuisson
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
	 * Add article
	 * @param article $article
	 * @return cuisson
	 */
	public function addArticle(article $article = null) {
		if($article !== null) {
			$this->articles->add($article);
			// $article->addCuisson($this);
		}
		return $this;
	}

	/**
	 * Remove article
	 * @param article $article
	 * @return cuisson
	 */
	public function removeArticle(article $article = null) {
		if($article !== null) {
			$this->articles->removeElement($article);
			// $article->removeCuisson($this);
		}
		return $this;
	}

	/**
	 * Get articles
	 * @return ArrayCollection 
	 */
	public function getArticles() {
		return $this->articles;
	}


}
