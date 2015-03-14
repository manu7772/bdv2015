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
use AcmeGroup\LaboBundle\Entity\statut;
use AcmeGroup\LaboBundle\Entity\adresse;
use AcmeGroup\LaboBundle\Entity\image;
// aeReponse
use labo\Bundle\TestmanuBundle\services\aetools\aeReponse;

/**
 * version
 *
 * @ORM\Entity
 * @ORM\Table(name="version")
 * @ORM\Entity(repositoryClass="AcmeGroup\LaboBundle\Entity\versionRepository")
 * @UniqueEntity(fields={"siren"}, message="Cette version existe déjà")
 */
class version extends entityBase {

	/**
	 * @var string
	 *
	 * @ORM\Column(name="nom", type="string", length=30, nullable=false, unique=true)
	 * @Assert\NotBlank(message = "Vous devez remplir ce champ.")
	 * @Assert\Length(
	 *      min = "3",
	 *      max = "30",
	 *      minMessage = "Le nom doit comporter au minimum {{ limit }} lettres.",
	 *      maxMessage = "Le nom doit comporter au maximum {{ limit }} lettres."
	 * )
	 */
	protected $nom;

	/**
	 * @var boolean
	 *
	 * @ORM\Column(name="defaut", type="boolean")
	 */
	protected $defaut;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="accroche", type="string", length=200, nullable=true, unique=false)
	 * @Assert\Length(
	 *      min = "1",
	 *      max = "200",
	 *      minMessage = "L'accroche doit comporter au moins {{ limit }} lettres.",
	 *      maxMessage = "L'accroche doit comporter au maximum {{ limit }} lettres."
	 * )
	 */
	protected $accroche;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="resofacebook", type="string", length=200, nullable=true, unique=false)
	 */
	protected $resofacebook;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="resotwitter", type="string", length=200, nullable=true, unique=false)
	 */
	protected $resotwitter;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="resogoogleplus", type="string", length=200, nullable=true, unique=false)
	 */
	protected $resogoogleplus;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="tvaIntra", type="string", length=100, nullable=true, unique=false)
	 */
	protected $tvaIntra;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="siren", type="string", length=100, nullable=true, unique=false)
	 */
	protected $siren;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="telpublic", type="string", length=25, nullable=true, unique=false)
	 * @Assert\Length(
	 *      min = "10",
	 *      max = "14",
	 *      minMessage = "Le téléphone doit comporter au moins {{ limit }} chiffres.",
	 *      maxMessage = "Le téléphone doit comporter au plus {{ limit }} chiffres."
	 * )
	 *
	 */
	protected $telpublic;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="telportable", type="string", length=25, nullable=true, unique=false)
	 * @Assert\Length(
	 *      min = "10",
	 *      max = "14",
	 *      minMessage = "Le téléphone portable doit comporter au moins {{ limit }} chiffres.",
	 *      maxMessage = "Le téléphone portable doit comporter au plus {{ limit }} chiffres."
	 * )
	 *
	 */
	protected $telportable;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="descriptif", type="text", nullable=true, unique=false)
	 */
	protected $descriptif;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="nomDomaine", type="string", length=200, nullable=false, unique=true)
	 * @Assert\Url(message = "Vous devez indiquer une URL valide et complète.")
	 * 
	 */
	protected $nomDomaine;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="hote", type="string", length=200, nullable=true, unique=false)
	 * @Assert\Url(message = "Vous devez indiquer une URL valide et complète.")
	 * 
	 */
	protected $hote;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="email", type="string", length=200, nullable=true, unique=false)
	 * @Assert\Email(message = "Vous devez indiquer un email valide et complet.")
	 * 
	 */
	protected $email;

	/**
	 * @var integer
	 *
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\LaboBundle\Entity\image")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $logo;

	/**
	 * @var integer
	 *
	 * @ORM\OneToOne(targetEntity="AcmeGroup\LaboBundle\Entity\image", cascade={"persist", "remove"})
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $favicon;

	/**
	 * @var integer
	 *
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\LaboBundle\Entity\image")
	 * @ORM\JoinColumn(nullable=true, unique=false)
	 */
	protected $imageEntete;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="couleurFond", type="string", length=30, nullable=false, unique=false)
	 */
	protected $couleurFond;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="templateIndex", type="string", length=30, nullable=false, unique=false)
	 */
	protected $templateIndex;

	/**
	 * @Gedmo\Slug(fields={"nom"})
	 * @ORM\Column(length=128, unique=true)
	 */
	protected $slug;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="AcmeGroup\LaboBundle\Entity\adresse", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true, unique=false)
     */
    protected $adresse;


	public function __construct() {
		parent::__construct();
		$this->couleurFond = "#FFFFFF";
		$this->defaut = false;
		$this->templateIndex = "Site";
		$this->resofacebook = null;
		$this->resotwitter = null;
		$this->resogoogleplus = null;
	}

	/**
	 * @Assert\True(message = "Vous devez renseigner soit le numéro TVAintra, soit le SIREN.")
	 */
	public function isVersionValid() {
		if($this->tvaIntra || $this->siren) return true;
		else return false;
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
	 * Set nom
	 *
	 * @param string $nom
	 * @return version
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
	 * Set resofacebook
	 *
	 * @param string $resofacebook
	 * @return version
	 */
	public function setResofacebook($resofacebook) {
		$this->resofacebook = $resofacebook;
	
		return $this;
	}

	/**
	 * Get resofacebook
	 *
	 * @return string 
	 */
	public function getResofacebook() {
		return $this->resofacebook;
	}

	/**
	 * Set resotwitter
	 *
	 * @param string $resotwitter
	 * @return version
	 */
	public function setResotwitter($resotwitter) {
		$this->resotwitter = $resotwitter;
	
		return $this;
	}

	/**
	 * Get resotwitter
	 *
	 * @return string 
	 */
	public function getResotwitter() {
		return $this->resotwitter;
	}

	/**
	 * Set resogoogleplus
	 *
	 * @param string $resogoogleplus
	 * @return version
	 */
	public function setResogoogleplus($resogoogleplus) {
		$this->resogoogleplus = $resogoogleplus;
	
		return $this;
	}

	/**
	 * Get resogoogleplus
	 *
	 * @return string 
	 */
	public function getResogoogleplus() {
		return $this->resogoogleplus;
	}

	/**
	 * Set defaut
	 *
	 * @param boolean $defaut
	 * @return version
	 */
	public function setDefaut($defaut) {
		$this->defaut = $defaut;
	
		return $this;
	}

	/**
	 * Get defaut
	 *
	 * @return boolean 
	 */
	public function getDefaut() {
		return $this->defaut;
	}

	/**
	 * Set accroche
	 *
	 * @param string $accroche
	 * @return version
	 */
	public function setAccroche($accroche) {
		$this->accroche = $accroche;
	
		return $this;
	}

	/**
	 * Get accroche
	 *
	 * @return string 
	 */
	public function getAccroche() {
		return $this->accroche;
	}

	/**
	 * Set tvaIntra
	 *
	 * @param string $tvaIntra
	 * @return version
	 */
	public function setTvaIntra($tvaIntra) {
		$this->tvaIntra = $tvaIntra;
	
		return $this;
	}

	/**
	 * Get tvaIntra
	 *
	 * @return string 
	 */
	public function getTvaIntra() {
		return $this->tvaIntra;
	}

	/**
	 * Set siren
	 *
	 * @param string $siren
	 * @return version
	 */
	public function setSiren($siren) {
		$this->siren = $siren;
	
		return $this;
	}

	/**
	 * Get siren
	 *
	 * @return string 
	 */
	public function getSiren() {
		return $this->siren;
	}

	/**
	 * Set telpublic
	 *
	 * @param string $telpublic
	 * @return version
	 */
	public function setTelpublic($telpublic) {
		$this->telpublic = $telpublic;
	
		return $this;
	}

	/**
	 * Get telpublic
	 *
	 * @return string 
	 */
	public function getTelpublic() {
		return $this->telpublic;
	}

	/**
	 * Set telportable
	 *
	 * @param string $telportable
	 * @return version
	 */
	public function setTelportable($telportable) {
		$this->telportable = $telportable;
	
		return $this;
	}

	/**
	 * Get telportable
	 *
	 * @return string 
	 */
	public function getTelportable() {
		return $this->telportable;
	}

	/**
	 * Set descriptif
	 *
	 * @param string $descriptif
	 * @return version
	 */
	public function setDescriptif($descriptif) {
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
	 * Set nomDomaine
	 *
	 * @param string $nomDomaine
	 * @return version
	 */
	public function setNomDomaine($nomDomaine) {
		$this->nomDomaine = $nomDomaine;
		$this->setHote();

		return $this;
	}

	/**
	 * Get nomDomaine
	 *
	 * @return string 
	 */
	public function getNomDomaine() {
		return $this->nomDomaine;
	}

	/**
	 * Set hote
	 *
	 * @return version
	 */
	public function setHote() {
		preg_match('#^[\w.]*\.(\w+\.[a-z]{2,6})[\w/._-]*$#',str_replace(array("http://", "https://"), "", $this->getNomDomaine()), $match);
		if(count($match) > 1) $this->hote = $match[1];
	
		return $this;
	}

	/**
	 * Get hote
	 *
	 * @return string 
	 */
	public function getHote() {
		return $this->hote;
	}

	/**
	 * Set email
	 *
	 * @param string $email
	 * @return version
	 */
	public function setEmail($email = null) {
		$this->email = $email;
	
		return $this;
	}

	/**
	 * Get email
	 *
	 * @return string 
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * Set couleurFond
	 *
	 * @param string $couleurFond
	 * @return version
	 */
	public function setCouleurFond($couleurFond) {
		$this->couleurFond = $couleurFond;
	
		return $this;
	}

	/**
	 * Get couleurFond
	 *
	 * @return string 
	 */
	public function getCouleurFond() {
		return $this->couleurFond;
	}

	/**
	 * Set templateIndex
	 *
	 * @param string $templateIndex
	 * @return version
	 */
	public function setTemplateIndex($templateIndex) {
		$this->templateIndex = $templateIndex;
	
		return $this;
	}

	/**
	 * Get templateIndex
	 *
	 * @return string 
	 */
	public function getTemplateIndex() {
		return $this->templateIndex;
	}

	/**
	 * Set logo
	 *
	 * @param image $logo
	 * @return version
	 */
	public function setLogo(\AcmeGroup\LaboBundle\Entity\image $logo = null) {
		$this->logo = $logo;
	
		return $this;
	}

	/**
	 * Get logo
	 *
	 * @return image 
	 */
	public function getLogo() {
		return $this->logo;
	}

	/**
	 * Set favicon
	 *
	 * @param image $favicon
	 * @return version
	 */
	public function setFavicon(\AcmeGroup\LaboBundle\Entity\image $favicon = null) {
		if($favicon !== null) $this->favicon = $favicon;
	
		return $this;
	}

	/**
	 * Get favicon
	 *
	 * @return image 
	 */
	public function getFavicon() {
		return $this->favicon;
	}

	/**
	 * Set imageEntete
	 *
	 * @param image $imageEntete
	 * @return version
	 */
	public function setImageEntete(\AcmeGroup\LaboBundle\Entity\image $imageEntete = null) {
		$this->imageEntete = $imageEntete;
	
		return $this;
	}

	/**
	 * Get imageEntete
	 *
	 * @return image 
	 */
	public function getImageEntete() {
		return $this->imageEntete;
	}

    /**
     * Set adresse
     *
     * @param adresse $adresse
     * @return partenaire
     */
    public function setAdresse(adresse $adresse = null)
    {
        $this->adresse = $adresse;
    
        return $this;
    }

    /**
     * Get adresse
     *
     * @return \AcmeGroup\LaboBundle\Entity\adresse 
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

}