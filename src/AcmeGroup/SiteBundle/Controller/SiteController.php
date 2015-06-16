<?php

namespace AcmeGroup\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class SiteController extends Controller {

	//////////////////////////
	// PAGES
	//////////////////////////

	public function homeAction() {
		// $aetools = $this->get('labobundle.aetools');
		// var_dump($aetools->getConfig());
		$this->addTel();
		$entities = $this->get('labobundle.entities')->defineEntity('article');
		$data['articles'] = $entities->getRepo()->findAllArticlesVer(3);
		return $this->render('AcmeGroupSiteBundle:Site:homepage.html.twig', $data);
	}

	protected function addTel() {
		$entities = $this->get('labobundle.entities')->defineEntity('telephone');
		$telephone = $entities->newObject(null, true);

		$telephone->setNom('test');
		$telephone->setNumero(rand(0,99)." ".rand(0,99)." ".rand(0,99)." ".rand(0,99)." ".rand(0,99));

		// $entities->defineEntity('version');
		// $version = $entities->getRepo()->find(rand(1,2));

		// $version->addTelephone($telephone);

		$entities->getEm()->persist($telephone);
		$entities->getEm()->flush();
	}

}



