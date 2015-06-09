<?php

namespace AcmeGroup\LaboBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
// Slug
use Gedmo\Mapping\Annotation as Gedmo;
use AcmeGroup\LaboBundle\Entity\baseL3EntityAttributs;
// Entities
use AcmeGroup\LaboBundle\Entity\article;
use AcmeGroup\LaboBundle\Entity\statut;
use AcmeGroup\LaboBundle\Entity\version;
use AcmeGroup\LaboBundle\Entity\pageweb;
// User
use AcmeGroup\UserBundle\Entity\User;

use \Exception;
use \DateTime;

/**
 * categorie
 *
 * @ORM\Entity
 * @ORM\Table(name="categorie")
 * @ORM\Entity(repositoryClass="AcmeGroup\LaboBundle\Entity\categorieRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\Tree(type="nested")
 */
class categorie extends baseL3EntityAttributs {

	/**
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\LaboBundle\Entity\pageweb")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $page;

	/**
	 * @var string
	 * @ORM\Column(name="nommenu", type="string", length=100, nullable=true)
	 */
	protected $nommenu;

	/**
	 * @var string
	 * @ORM\Column(name="couleur", type="string", length=64, nullable=true)
	 */
	protected $couleur;

	/**
	 * @Gedmo\TreeLeft
	 * @ORM\Column(name="lft", type="integer")
	 */
	protected $lft;

	/**
	 * @Gedmo\TreeLevel
	 * @ORM\Column(name="lvl", type="integer")
	 */
	protected $lvl;

	/**
	 * @Gedmo\TreeRight
	 * @ORM\Column(name="rgt", type="integer")
	 */
	protected $rgt;

	/**
	 * @Gedmo\TreeRoot
	 * @ORM\Column(name="root", type="integer", nullable=true)
	 */
	protected $root;

	/**
	 * @Gedmo\TreeParent
	 * @ORM\ManyToOne(targetEntity="categorie", inversedBy="children", cascade={"persist"})
	 * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $parent;

	/**
	 * @ORM\OneToMany(targetEntity="categorie", mappedBy="parent")
	 * @ORM\OrderBy({"lft" = "ASC"})
	 */
	protected $children;


	public function __construct() {
		parent::__construct();
		$this->couleur = '#ffffff';
	}

// DEBUT --------------------- à inclure dans toutes les entités ------------------------

	/**
	 * Renvoie true si l'entité est valide
	 * @Assert\True(message = "Cette catégorie n'est pas valide.")
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


	public function isMenu() {
		if($this->nommenu !== null) return true;
		return false;
	}

	public function setNommenu($nommenu = null) {
		$this->nommenu = $nommenu;
	}

	public function getNommenu() {
		return $this->nommenu;
	}

	public function setCouleur($couleur = null) {
		$this->couleur = $couleur;
	}

	public function getCouleur() {
		return $this->couleur;
	}

	public function setPage(pageweb $page = null) {
		$this->page = $page;
		return $this;
	}

	public function getPage() {
		return $this->page;
	}

	public function setParent(categorie $parent = null) {
		$this->parent = $parent;
	}

	public function getParent() {
		return $this->parent;
	}

	public function getChildren() {
		return $this->children;
	}



}
