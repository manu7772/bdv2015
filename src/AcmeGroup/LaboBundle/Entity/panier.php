<?php

namespace AcmeGroup\LaboBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
// Entities
use AcmeGroup\LaboBundle\Entity\article;
// User
use AcmeGroup\UserBundle\Entity\User;

use \Exception;
use \DateTime;

/**
 * panier
 *
 * @ORM\Entity
 * @ORM\Table(name="panier")
 * @ORM\Entity(repositoryClass="AcmeGroup\LaboBundle\Entity\panierRepository")
 */
class panier {

	/**
	 * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\UserBundle\Entity\User", inversedBy="paniers")
	 * @ORM\JoinColumn(nullable=false, unique=false)
	 */
	protected $user;

	/**
	 * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\LaboBundle\Entity\article", inversedBy="paniers")
	 * @ORM\JoinColumn(nullable=false, unique=false)
	 */
	protected $article;

	/**
	 * @var integer
	 * @ORM\Column(name="quantite", type="integer", nullable=false, unique=false)
	 */
	protected $quantite;

	/**
	 * @var DateTime
	 * @ORM\Column(name="dateCreation", type="datetime", nullable=false)
	 */
	protected $dateCreation;

	/**
	 * @var DateTime
	 * @ORM\Column(name="dateMaj", type="datetime", nullable=true)
	 */
	protected $dateMaj;



	public function __construct() {
		$this->dateCreation = new DateTime();
		$this->dateMaj = null;
		$this->quantite = 0;
	}

// DEBUT --------------------- à inclure dans toutes les entités ------------------------

	/**
	 * Renvoie true si l'entité est valide
	 * @Assert\True(message = "Ce panier n'est pas valide.")
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
			if($this->quantite < 0) $this->quantite = 0;
		}
		return $verif;
	}

// FIN --------------------- à inclure dans toutes les entités ------------------------

	/**
	 * Set user
	 * @param User $user
	 * @return panier
	 */
	public function setUser(User $user) {
		$this->user = $user;
		$user->addPanier($this);
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
	 * Set article
	 * @param article $article
	 * @return panier
	 */
	public function setArticle(article $article) {
		$this->article = $article;
		$article->addPanier($this);
		return $this;
	}

	/**
	 * Get article
	 * @return article 
	 */
	public function getArticle() {
		return $this->article;
	}

	/**
	 * Get prixtotal
	 * @return float
	 */
	public function getPrixtotal() {
		if($this->article->getPrix() !== null) return ($this->article->getPrix() * $this->quantite);
		else return 0;
	}

	/**
	 * Get getPrixtotaltxt
	 * @return string
	 */
	public function getPrixtotaltxt() {
		return number_format($this->getPrixtotal(), 2, ",", "");
	}

	/**
	 * Set quantite
	 * @param integer $quantite
	 * @return panier
	 */
	public function setQuantite($quantite) {
		$this->quantite = $quantite;
		return $this;
	}

	/**
	 * ajouteQuantite
	 * @param integer $quantite
	 * @return panier
	 */
	public function ajouteQuantite($quantite) {
		$this->quantite += $quantite;
		return $this;
	}

	/**
	 * retireQuantite
	 * @param integer $quantite
	 * @return panier
	 */
	public function retireQuantite($quantite) {
		$this->quantite -= $quantite;
		if($this->quantite < 0) $this->quantite = 0;
		return $this;
	}

	/**
	 * Get quantite
	 * @return integer 
	 */
	public function getQuantite() {
		return $this->quantite;
	}

	/**
	 * Set dateCreation
	 * @param DateTime $dateCreation
	 * @return panier
	 */
	public function setDateCreation($dateCreation) {
		$this->dateCreation = $dateCreation;
		return $this;
	}

	/**
	 * Get dateCreation
	 * @return DateTime 
	 */
	public function getDateCreation() {
		return $this->dateCreation;
	}

    /**
     * @ORM\PreUpdate
     */
    public function updateDateMaj() {
        $this->setDateMaj(new DateTime());
    }

	/**
	 * Set dateMaj
	 * @param DateTime $dateMaj
	 * @return panier
	 */
	public function setDateMaj($dateMaj) {
		$this->dateMaj = $dateMaj;
		return $this;
	}

	/**
	 * Get dateMaj
	 * @return DateTime 
	 */
	public function getDateMaj() {
		return $this->dateMaj;
	}

}