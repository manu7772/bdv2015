<?php

namespace AcmeGroup\LaboBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
// slug/Tree
use Gedmo\Mapping\Annotation as Gedmo;
use AcmeGroup\LaboBundle\Entity\baseEntityImage;
// Entities
use AcmeGroup\LaboBundle\Entity\typeImage;
// User
use AcmeGroup\UserBundle\Entity\User;

use \Exception;
use \DateTime;

/**
 * download
 *
 * @ORM\Entity
 * @ORM\Table(name="download")
 * @ORM\Entity(repositoryClass="AcmeGroup\LaboBundle\Entity\downloadRepository")
 */
class download {

    /**
     * @var integer
     *
     * @ORM\Id @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="binaryFile", type="blob")
	 */
	private $binaryFile;
	
	/**
	 * Format de fichier
	 * @ORM\ManyToOne(targetEntity="AcmeGroup\LaboBundle\Entity\fileFormat")
	 * @ORM\JoinColumn(nullable=false, unique=false)
	 */
	protected $format;




}