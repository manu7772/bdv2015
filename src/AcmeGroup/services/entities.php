<?php

nameSpace AcmeGroup\services;

use Symfony\Component\DependencyInjection\ContainerInterface;
// entitesService
use laboBundle\services\entitiesServices\entitesService;
use \Exception;
use \DateTime;

class entities extends entitesService {

	const SERVICE_ENTITE = 'version';

	public function __construct(ContainerInterface $container = null) {
		parent::__construct($container);
		// initialisation pour version
		if($this->defineEntity(self::SERVICE_ENTITE) === false) throw new Exception('Entité '.self::SERVICE_ENTITE.' inexistante !', 1);
		return $this;
	}

}