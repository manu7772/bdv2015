<?php

namespace AcmeGroup\LaboBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * fileFormat
 *
 * @ORM\Entity
 * @ORM\Table(name="fileFormat")
 * @ORM\Entity(repositoryClass="AcmeGroup\LaboBundle\Entity\fileFormatRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class fileFormat {

	const DEFAULT_QUESTION_ICON = 'fa-question';

	/**
	 * @var integer
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @var string
	 * @ORM\Column(name="nom", type="string", length=255)
	 */
	private $nom;
	
	/**
	 * @var string
	 * @ORM\Column(name="icon", type="string", length=24)
	 */
	private $icon;
	
	/**
	 * @var string
	 * @ORM\Column(name="content_type", type="string", length=255)
	 */
	private $contentType;

	/**
	 * @var boolean
	 * @ORM\Column(name="enabled", type="boolean", nullable=false, unique=false)
	 */
	private $enabled;

	private $typeIcons;
	private $knownFormats;

	public function __construct() {
		$this->getTypeIcons();
		$this->icon = $this->getDefaultIcon();
		$this->enabled = false;
	}

	/**
	 * Define default icon if recognized
	 * @ORM\PrePersist()
	 * @ORM\PreUpdate()
	 * @return fileFormat
	 */
	public function verif() {
		if($this->icon === $this->getDefaultIcon()) {
			// pas d'icone particulier attributé : on recherche
			if(array_key_exists($this->getContentType(), $this->knownFormats)) {
				$this->setIcon($this->knownFormats[$this->getContentType()]);
			}
		}
		return $this;
	}

	public function __toString(){
		return $this->nom;
	}

	/**
	 * Get id
	 * @return integer
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Set name
	 * @param string $name
	 * @return fileFormat
	 */
	public function setName($name) {
		$this->name = $name;
		return $this;
	}

	/**
	 * Get name
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Set enabled
	 * @param boolean $enabled
	 * @return fileFormat
	 */
	public function setEnabled($enabled = true) {
		if(!is_bool($enabled)) $enabled = false;
		$this->enabled = $enabled;
		return $this;
	}

	/**
	 * Get enabled
	 * @return boolean
	 */
	public function getEnabled() {
		return $this->enabled;
	}

	/**
	 * Set icon
	 * @param string $icon
	 * @return fileFormat
	 */
	public function setIcon($icon = null) {
		$icons = $this->getTypeIcons();
		if(array_key_exists($icon, $icons)) $this->icon = $icon;
			else $this->icon = $this->getDefaultIcon();
		return $this;
	}

	/**
	 * Get icon
	 * @return string
	 */
	public function getIcon() {
		return $this->icon;
	}

	/**
	 * Get types of icons
	 * @return array
	 */
	public function getTypeIcons() {
		$typeIcons = array(
			0	=> 'fa-file-o',
			1	=> 'fa-file-text-o',
			2	=> 'fa-file-archive-o',
			3	=> 'fa-file-audio-o',
			4	=> 'fa-file-code-o',
			5	=> 'fa-file-excel-o',
			6	=> 'fa-file-image-o',
			7	=> 'fa-file-movie-o',
			8	=> 'fa-file-pdf-o',
			9	=> 'fa-file-photo-o',
			10	=> 'fa-file-picture-o',
			11	=> 'fa-file-powerpoint-o',
			12	=> 'fa-file-sound-o',
			13	=> 'fa-file-video-o',
			14	=> 'fa-file-word-o',
			15	=> 'fa-file-zip-o',
		);
		// icones pour formats connus
		$this->knownFormats = array(
			'image/png'					=> 'fa-file-image-o',
			'image/jpg'					=> 'fa-file-image-o',
			'image/jpeg'				=> 'fa-file-image-o',
			'image/gif'					=> 'fa-file-image-o',
			'text/plain'				=> 'fa-file-word-o',
			'application/pdf'			=> 'fa-file-pdf-o',
			'application/msword'		=> 'fa-file-word-o',
			'application/vnd.ms-excel'	=> 'fa-file-excel-o',
			'application/zip'			=> 'fa-file-zip-o',
		);
		// attribution…
		foreach ($typeIcons as $key => $value) {
			$iconCode = '<i class="fa '.$value.' fa-2x"></i> ';
			$this->typeIcons[$value] = $iconCode.str_replace(array('fa-','-o'), '', $value);
		}
		return $this->typeIcons;
	}

	/**
	 * Get types of icons
	 * @return array
	 */
	public function getDefaultIcon() {
		// $icons = $this->getTypeIcons();
		// reset($icons);
		// return key($icons);
		return self::DEFAULT_QUESTION_ICON;
	}

	/**
	 * Set contentType
	 * @param string $contentType
	 * @return fileFormat
	 */
	public function setContentType($contentType) {
		$this->contentType = $contentType;
		return $this;
	}

	/**
	 * Get contentType
	 * @return string
	 */
	public function getContentType() {
		return $this->contentType;
	}

	/**
	 * Get first part of content-type (type)
	 * @return string
	 */
	public function getType(){
		return explode('/', $this->getContentType())[0];
	}

	/**
	 * is a IMAGE type ?
	 * @return boolean
	 */
	public function isImage(){
		return strtolower($this->getType()) == "image";
	}

	/**
	 * is a PDF type ?
	 * @return boolean
	 */
	public function isPdf(){
		$isPdf = explode('/', $this->getContentType())[1];
		return strtolower($isPdf) == "pdf";
	}
	
}
