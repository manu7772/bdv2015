<?php

namespace AcmeGroup\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class TestController extends Controller {

	//////////////////////////
	// PAGES
	//////////////////////////

	public function test1Action($nb = 4) {
		// $aetools = $this->get('labobundle.aetools');
		// $aetools->consoleLog("TestController", "TestController : ".'article');
		// $articles = $this->get('labobundle.entities')->defineEntity('article');
		$articles = $this->get('labobundle.article');
		// $versions = $this->get('labobundle.version');
		// $aetools->consoleLog("TestController", "TestController article : ".$articles->getEntityClassName());
		// $aetools->consoleLog("TestController", "TestController version : ".$versions->getEntityClassName());
		// echo($nb."<br>");
		$data['page'] = 1;
		$articles->setPagination($nb, $data['page']);
		$data['articles'] = $articles->findAllArticlesVer($nb);
		$data['nombrePages'] = ceil(count($data['articles']) / $nb);
		// echo("Articles count results : ".$data['nombrePages']."<br>");
		// $aetools->consoleLog("TestController", $articles->getEntityShortName()." : ".count($data['articles']));
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



