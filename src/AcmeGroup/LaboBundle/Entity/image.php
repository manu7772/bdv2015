<?php

namespace AcmeGroup\LaboBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
// slug/Tree
use Gedmo\Mapping\Annotation as Gedmo;
use labo\Bundle\TestmanuBundle\Entity\entityBase;
// Entities
use AcmeGroup\LaboBundle\Entity\statut;
use AcmeGroup\LaboBundle\Entity\version;
use AcmeGroup\LaboBundle\Entity\typeImage;
// User
use AcmeGroup\UserBundle\Entity\User;
// aeReponse
use labo\Bundle\TestmanuBundle\services\aetools\aeReponse;

/**
 * image
 *
 * @ORM\Entity
 * @ORM\Table(name="image")
 * @ORM\Entity(repositoryClass="AcmeGroup\LaboBundle\Entity\imageRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class image extends entityBase {

	/**
	 * @var string
	 *
	 * @ORM\Column(name="descriptif", type="text", nullable=true, unique=false)
	 */
	protected $descriptif;

	/**
	 * @var url
	 *
	 * @ORM\Column(name="url", type="text", nullable=true, unique=false)
	 */
	protected $url;

	/**
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\LaboBundle\Entity\statut")
	 * @ORM\JoinColumn(nullable=false, unique=false)
	 */
	protected $statut;

	/**
	 *
	 * @ORM\ManyToMany(targetEntity="AcmeGroup\LaboBundle\Entity\typeImage", inversedBy="images")
	 * @ORM\JoinColumn(nullable=false, unique=false)
	 */
	protected $typeImages;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="fichierOrigine", type="string", length=200)
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $fichierOrigine;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="fichierNom", type="string", length=200)
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $fichierNom;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="tailleX", type="integer", nullable=true, unique=false)
	 */
	protected $tailleX;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="tailleY", type="integer", nullable=true, unique=false)
	 */
	protected $tailleY;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="tailleMo", type="integer", nullable=true, unique=false)
	 */
	protected $tailleMo;

	/**
	 * @Assert\File(maxSize="6000000")
	 */
	protected $file;

	/**
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\UserBundle\Entity\User", inversedBy="images")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $user;

	/**
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\LaboBundle\Entity\version" inversedBy="images")
	 * @ORM\JoinColumn(nullable=false, unique=false)
	 */
	protected $version;

	/**
	 * @ORM\OneToMany(targetEntity="AcmeGroup\LaboBundle\Entity\version" mappedBy="images")
	 * @ORM\JoinColumn(nullable=false, unique=false)
	 */
	protected $articlesIP;

	protected $tempFileName;
	protected $ext;
	// Eléments de formulaire
	protected $remove;

	public function __construct() {
		parent::__construct();
		$this->alt = "image";
		$this->fichierNom = "";
		$this->typeImages = new ArrayCollection();
		$this->tempFileName = null;
		$this->fichierOrigine = null;
		$this->ext = null;
		$this->remove = false; // pour effacer l'image
	}

	/**
	 * @Assert/True(message = "Cette image n'est pas valide.")
	 */
	public function isImageValid() {
		return true;
	}

	/**
	 * Set remove
	 *
	 * @param boolean $remove
	 * @return baseEntity
	 */
	public function setRemove($remove) {
		$this->remove = $remove;
	
		return $this;
	}

	/**
	 * Get remove
	 *
	 * @return boolean 
	 */
	public function getRemove() {
		return $this->remove;
	}

	/**
	 * Set nom
	 *
	 * @param string $nom
	 * @return baseEntity
	 */
	public function setNom($nom) {
		$this->nom = trim($nom);
	
		return $this;
	}

	/**
	 * Get nom
	 *
	 * @return string 
	 */
	public function getNom() {
		return $this->nom;
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

	/**
	 * Set url
	 *
	 * @param string $url
	 * @return baseEntity
	 */
	public function setUrl($url = null) {
		$this->url = trim($url);
	
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
	 * Set statut
	 *
	 * @param integer $statut
	 * @return baseEntity
	 */
	public function setStatut(statut $statut = null) {
		$this->statut = $statut;
	
		return $this;
	}

	/**
	 * Get statut
	 *
	 * @return statut 
	 */
	public function getStatut() {
		return $this->statut;
	}

	/**
	 * Add typeImages
	 *
	 * @param typeImage $typeImages
	 * @return images
	 */
	public function addTypeImage(typeImage $typeImage) {
		$this->typeImages[] = $typeImage;
	
		return $this;
	}

	/**
	 * Remove typeImages
	 *
	 * @param typeImage $typeImage
	 */
	public function removeTypeImage(typeImage $typeImage) {
		$this->typeImages->removeElement($typeImage);
	}

	/**
	 * Get typeImage
	 *
	 * @return ArrayCollection 
	 */
	public function getTypeImages() {
		return $this->typeImages;
	}

	/**
	 * Set fichierOrigine
	 *
	 * @param string $fichierOrigine
	 * @return image
	 */
	public function setFichierOrigine($fichierOrigine = null) {
		$this->fichierOrigine = $fichierOrigine;
	
		return $this;
	}

	/**
	 * Get fichierOrigine
	 *
	 * @return string 
	 */
	public function getFichierOrigine() {
		return $this->fichierOrigine;
	}

	/**
	 * Set fichierNom
	 *
	 * @param string $fichierNom
	 * @return image
	 */
	public function setFichierNom($fichierNom = null) {
		$this->fichierNom = $fichierNom;
	
		return $this;
	}

	/**
	 * Get fichierNom
	 *
	 * @return string 
	 */
	public function getFichierNom() {
		return $this->fichierNom;
	}

	/**
	 * Set tailleX
	 *
	 * @param integer $tailleX
	 * @return image
	 */
	public function setTailleX($tailleX) {
		$this->tailleX = $tailleX;
	
		return $this;
	}

	/**
	 * Get tailleX
	 *
	 * @return integer 
	 */
	public function getTailleX() {
		return $this->tailleX;
	}

	/**
	 * Set tailleY
	 *
	 * @param integer $tailleY
	 * @return image
	 */
	public function setTailleY($tailleY) {
		$this->tailleY = $tailleY;
	
		return $this;
	}

	/**
	 * Get tailleY
	 *
	 * @return integer 
	 */
	public function getTailleY() {
		return $this->tailleY;
	}

	/**
	 * Set tailleMo
	 *
	 * @param integer $tailleMo
	 * @return image
	 */
	public function setTailleMo($tailleMo) {
		$this->tailleMo = $tailleMo;
	
		return $this;
	}

	/**
	 * Get tailleMo
	 *
	 * @return integer 
	 */
	public function getTailleMo() {
		return $this->tailleMo;
	}

	/**
	 * Set slug
	 *
	 * @param integer $slug
	 * @return baseEntity
	 */
	public function setSlug($slug) {
		$this->slug = $slug;
		return $this;
	}    

	/**
	 * Get slug
	 *
	 * @return string
	 */
	public function getSlug() {
		return $this->slug;
	}

	/**
	 * Set file
	 *
	 * @param integer $file
	 * @return image
	 */
	public function setFile(UploadedFile $file = null) {
		$this->file = $file;
		if(null !== $this->fichierOrigine) {
			$this->tempFileName = $this->fichierOrigine;
			$this->fichierOrigine = null;
		}
	
		return $this;
	}

	/**
	 * Get file
	 *
	 * @return UploadedFile 
	 */
	public function getFile() {
		return $this->file;
	}

	/**
	 * Set tempFileName
	 *
	 */
	public function setTempFileName($tempFileName = null) {
		$this->tempFileName = $tempFileName;
		return $this;
	}

	/**
	 * Get tempFileName
	 *
	 * @return string 
	 */
	public function getTempFileName() {
		return $this->tempFileName;
	}

	/**
	 * Set ext
	 *
	 */
	public function setExt($ext) {
		$this->ext = $ext;
		return $this;
	}

	/**
	 * Get ext
	 *
	 * @return string 
	 */
	public function getExt() {
		return $this->ext;
	}

	/**
	 * Set user
	 *
	 * @param User $user
	 * @return image
	 */
	public function setUser(User $user = null) {
		$this->user = $user;
	
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

	/**
	 * Set version
	 *
	 * @param version $version
	 * @return image
	 */
	public function setVersion(version $version) {
		$this->version = $version;
	
		return $this;
	}

	/**
	 * Get version
	 *
	 * @return version 
	 */
	public function getVersion() {
		return $this->version;
	}


}