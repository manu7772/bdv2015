<?php
// src/AcmeGroup/eventListeners/siteListener/siteListener.php

namespace AcmeGroup\eventListeners\siteListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use AcmeGroup\services\aetools\aetools;
use AcmeGroup\services\entitiesServices\version;
use AcmeGroup\services\entitiesServices\categorie;

class siteListener {

	private $itClass = array();
	private $serviceMethode = "serviceEventInit";
	private $items = array(	// entités à initialiser
		"acmeGroup.aetools",
		"acmeGroup.version",
		"acmeGroup.categorie",
		);

	public function __construct(ContainerInterface $container) {
		$this->container = $container;
		$this->serviceSess = $this->container->get('request')->getSession();
		foreach($this->items as $item) {
			$this->itClass[$item] = $this->container->get($item);
		}
	}

	public function load_session_items(FilterControllerEvent $event) {
		// Réinitialisation du reloadAll --> rechargement forcé de tous les services
		// --> si un service active reloadAll (à true), alors tous les services SUIVANTS* sont également forcés au rechargement SI celui-ci est rechargé *(ordre dans $this->items)
		//     pour forcer le rechargement (SI rechargé), mettre $this->eventReloadForcer = true dans son constructeur.
		// $this->serviceSess->set("siteListener", array("reloadAll" => false));
		// $this->aff($event);
		// Chargement des services, dans l'ordre de $this->items
		$serviceMethode = $this->serviceMethode;
		foreach($this->itClass as $nom => $item) {
			if(HttpKernelInterface::MASTER_REQUEST === $event->getRequestType()) {
				if(method_exists($this->itClass[$nom], $serviceMethode)) {
					// echo("<h1>Service en session : ".$nom."</h1>");
					$this->itClass[$nom]->$serviceMethode($event);
				}
			}
		}
	}

	private function aff(FilterControllerEvent $event) {
		// affichage :
		echo('MASTER_REQUEST : '.HttpKernelInterface::MASTER_REQUEST."<br >");
		echo('getRequestType : '.$event->getRequestType()."<br >");
	}

}