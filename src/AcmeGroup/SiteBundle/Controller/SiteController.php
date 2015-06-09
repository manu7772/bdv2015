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
		return $this->render('AcmeGroupSiteBundle:Site:homepage.html.twig');
	}



}



