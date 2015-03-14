<?php
// src/AcmeGroup/services/entitiesServices/membre.php

namespace AcmeGroup\services\entitiesServices;

use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use labo\Bundle\TestmanuBundle\services\entitiesServices\entitiesGeneric;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
// use Symfony\Component\Form\FormFactoryInterface;

use AcmeGroup\LaboBundle\Classes\paramForRepo;

class membre extends entitiesGeneric {
	protected $service = array();

	public function __construct(ContainerInterface $container) {
		parent::__construct($container);
		$this->defineEntity("membre");
	}




}

?>
