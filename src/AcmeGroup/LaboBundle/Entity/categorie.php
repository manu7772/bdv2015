<?php

namespace AcmeGroup\LaboBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
// Slug
use Gedmo\Mapping\Annotation as Gedmo;
use labo\Bundle\TestmanuBundle\Entity\entityBase;
// Entities
use AcmeGroup\LaboBundle\Entity\article;
use AcmeGroup\LaboBundle\Entity\statut;
use AcmeGroup\LaboBundle\Entity\version;
use AcmeGroup\LaboBundle\Entity\pageweb;
// User
use AcmeGroup\UserBundle\Entity\User;
// aeReponse
use labo\Bundle\TestmanuBundle\services\aetools\aeReponse;

/**
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks()
 */
/**
 * categorie
 *
 * @ORM\Entity
 * @ORM\Table(name="categorie")
 * @ORM\Entity(repositoryClass="AcmeGroup\LaboBundle\Entity\categorieRepository")
 * @Gedmo\Tree(type="nested")
 */
class categorie extends entityBase {

	/**
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\LaboBundle\Entity\pageweb")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $page;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="nomroutepage", type="string", length=255, nullable=true)
	 */
	protected $nomroutepage;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="nommenu", type="string", length=100, nullable=true)
	 */
	protected $nommenu;

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

	/**
	 * @var string
	 *
	 * @ORM\Column(name="descriptif", type="text", nullable=true, unique=false)
	 */
	protected $descriptif;

	/**
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\LaboBundle\Entity\statut")
	 * @ORM\JoinColumn(nullable=false, unique=false)
	 */
	protected $statut;

	/**
	 * @Gedmo\Slug(fields={"nom"})
	 * @ORM\Column(length=128, unique=true)
	 */
	protected $slug;

	/**
	 * @var array
	 *
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\LaboBundle\Entity\version")
	 * @ORM\JoinColumn(nullable=false, unique=false)
	 */
	protected $version;

	/**
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\UserBundle\Entity\User", inversedBy="categories")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $user;

	/**
	 * @var boolean
	 *
	 * @ORM\Column(name="plusVisible", type="boolean")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $plusVisible;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="couleur", type="string", length=30, nullable=false, unique=false)
	 */
	protected $couleur;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="parametreUrl", type="string", nullable=true, unique=false)
	 */
	protected $parametreUrl;


	public function __construct() {
		parent::__construct();

		$this->plusVisible = false;
		$this->couleur = "FFFFFF";
		$this->parametreUrl = "";
	}

	/**
	 * @Assert/True(message = "Cette catégorie n'est pas valide.")
	 */
	public function isCategorieValid() {
		return true;
	}


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

	public function setNomroutepage($nomroutepage = null) {
		$this->nomroutepage = $nomroutepage;
	}

	public function getNomroutepage() {
		return $this->nomroutepage;
	}

	public function setPage(pageweb $page = null) {
		$this->page = $page;
		if(is_object($page)) {
			$this->setNomroutepage($page->getRoute()."___".$page->getSlug());
		} else {
			$this->setNomroutepage(null);
		}
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

	/**
	 * Set descriptif
	 *
	 * @param string $descriptif
	 * @return baseEntity
	 */
	public function setDescriptif($descriptif = null) {
		$this->descriptif = $descriptif;
		return $this;
	}

	/**
	 * Get descriptif
	 *
	 * @return string 
	 */
	public function getDescriptif() {
		return $this->descriptif;
	}

	 * Set statut
	 *
	 * @param integer $statut
	 * @return baseEntity
	 */
	public function setStatut(statut $statut) {
		$this->statut = $statut;
		return $this;
	}

	/**
	 * Get statut
	 *
	 * @return AcmeGroup\LaboBundle\Entity\statut 
	 */
	public function getStatut() {
		return $this->statut;
	}

	/**
	 * Set version
	 *
	 * @param string $version
	 * @return categorie
	 */
	public function setVersion($version) {
		$this->version = $version;
	
		return $this;
	}

	/**
	 * Get version
	 *
	 * @return string 
	 */
	public function getVersion() {
		return $this->version;
	}

	/**
	 * Set plusVisible
	 *
	 * @param boolean $plusVisible
	 * @return categorie
	 */
	public function setPlusVisible($plusVisible) {
		$this->plusVisible = $plusVisible;
	
		return $this;
	}

	/**
	 * Get plusVisible
	 *
	 * @return boolean 
	 */
	public function getPlusVisible() {
		return $this->plusVisible;
	}

	/**
	 * Set couleur
	 *
	 * @param string $couleur
	 * @return version
	 */
	public function setCouleur($couleur) {
		$this->couleur = $couleur;
	
		return $this;
	}

	/**
	 * Get couleur
	 *
	 * @return string 
	 */
	public function getCouleur() {
		return $this->couleur;
	}

	/**
	 * Set parametreUrl
	 *
	 * @param string $parametreUrl
	 * @return version
	 */
	public function setParametreUrl($parametreUrl) {
		$this->parametreUrl = $parametreUrl;
	
		return $this;
	}

	/**
	 * Get parametreUrl
	 *
	 * @return string 
	 */
	public function getParametreUrl() {
		return $this->parametreUrl;
	}

	/**
	 * Set user
	 *
	 * @param User $user
	 * @return categorie
	 */
	public function setUser(User $user = null) {
		$this->user = $user;
		$user->removeElement($this);
	
		return $this;
	}

	/**
	 * Get user
	 *
	 * @return User 
	 */
	public function getUser() {
		return $this->user;
	}

}
