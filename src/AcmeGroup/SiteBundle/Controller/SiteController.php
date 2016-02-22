<?php

namespace AcmeGroup\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class SiteController extends Controller {

	const DEFAUT_PG_ARTICLES 	= 1;
	const DEFAUT_NB_ARTICLES 	= 4;

	//////////////////////////
	// PAGES
	//////////////////////////

	/**
	 * page d'accueil du site
	 * @return Response
	 */
	public function homeAction() {
		$data = array();
		// $version = $this->get('labobundle.version');
		// $articles = $this->get('labobundle.article');
		// $data['page'] = self::DEFAUT_PG_ARTICLES;
		// $articles->setPagination(self::DEFAUT_NB_ARTICLES, $data['page']);
		// $data['articles'] = $articles->findAllArticlesVer(self::DEFAUT_NB_ARTICLES);
		// echo($articles->getEntityShortName()." : ".count($data['articles'])."<br>");
		$em = $this->getDoctrine()->getManager();
		$repo = $em->getRepository("AcmeGroup\\LaboBundle\\Entity\\article");
		$data['articles'] = $repo->findAll();
		// $data['articles'] = array();
		$data['version'] = $this->get('labobundle.entities')->getCurrentVersion();
		return $this->render('AcmeGroupSiteBundle:Site:homepage.html.twig', $data);
	}

	public function pagewebAction($option, $option2 = null) {
		$data = array();
		$data['version'] = $this->get('labobundle.entities')->getCurrentVersion();
		switch ($option) {
			case 'article': // catégories
				$articles = array();
				break;
			
			default:
				# code...
				break;
		}
		return $this->render('AcmeGroupSiteBundle:Site:homepage.html.twig', $data);
	}

	public function categorieAction($categorieSlug) {

	}

	/**
	 * code HTML pour menu depuis catégorie
	 * @param string $categorieSlug
	 * @return string
	 */
	public function categorieMenuAction($categorieSlug) {
		// $menu = $this->get('labobundle.categorie')->menuCategories($categorieSlug);
		// return new Response($menu);
		return new Response('<p>Menu…</p>');
	}

}


			// <div class="col-sm-3 col-md-3 padding-right-resp"><!--colonne left-->
			// 	<div class="left-sidebar"><!--left-sidebar-->
			// 		<div class="panel-group category-products" id="accordian"><!--category-products-->
			// 			<div class="panel panel-default"><!--product 1-->
			// 				<div class="panel-heading">
			// 					<h4 class="panel-title">
			// 						<a data-toggle="collapse" data-parent="#accordian" href="#boeuf">
			// 							<span class="badge pull-right"><i class="fa fa-plus"></i></span>
			// 							BŒUF3
			// 						</a>
			// 					</h4>
			// 				</div>
			// 				<div id="boeuf" class="panel-collapse collapse">
			// 					<div class="panel-body">
			// 						<ul>
			// 							<li><a href="#">pièces du boucher </a></li>
			// 							<li><a href="#">à rôtir </a></li>
			// 							<li><a href="#">à griller </a></li>
			// 							<li><a href="#">à braiser</a></li>
			// 							<li><a href="#">abats </a></li>
			// 						</ul>
			// 					</div>
			// 				</div>
			// 			</div><!--/product 1-->
			// 			<div class="panel panel-default"><!--product 2-->
			// 				<div class="panel-heading">
			// 					<h4 class="panel-title">
			// 						<a data-toggle="collapse" data-parent="#accordian" href="#veau">
			// 							<span class="badge pull-right"><i class="fa fa-plus"></i></span>
			// 							VEAU
			// 						</a>
			// 					</h4>
			// 				</div>
			// 				<div id="veau" class="panel-collapse collapse">
			// 					<div class="panel-body">
			// 						<ul>
			// 							<li><a href="#">pièces du boucher </a></li>
			// 							<li><a href="#">à rôtir </a></li>
			// 							<li><a href="#">à griller </a></li>
			// 							<li><a href="#">à braiser</a></li>
			// 							<li><a href="#">abats </a></li>
			// 						</ul>
			// 					</div>
			// 				</div>
			// 			</div><!--/product 2-->
			// 			<div class="panel panel-default"><!--product 3-->
			// 				<div class="panel-heading">
			// 					<h4 class="panel-title">
			// 						<a data-toggle="collapse" data-parent="#accordian" href="#agneau">
			// 							<span class="badge pull-right"><i class="fa fa-plus"></i></span>
			// 							AGNEAU
			// 						</a>
			// 					</h4>
			// 				</div>
			// 				<div id="agneau" class="panel-collapse collapse">
			// 					<div class="panel-body">
			// 						<ul>
			// 							<li><a href="#">pièces du boucher </a></li>
			// 							<li><a href="#">à rôtir </a></li>
			// 							<li><a href="#">à griller </a></li>
			// 							<li><a href="#">à braiser</a></li>
			// 							<li><a href="#">abats </a></li>
			// 						</ul>
			// 					</div>
			// 				</div>
			// 			</div><!--/product 3-->
			// 			<div class="panel panel-default"><!--product 4-->
			// 				<div class="panel-heading">
			// 					<h4 class="panel-title">
			// 						<a data-toggle="collapse" data-parent="#accordian" href="#porc">
			// 							<span class="badge pull-right"><i class="fa fa-plus"></i></span>
			// 							PORC
			// 						</a>
			// 					</h4>
			// 				</div>
			// 				<div id="porc" class="panel-collapse collapse">
			// 					<div class="panel-body">
			// 						<ul>
			// 							<li><a href="#">pièces du boucher </a></li>
			// 							<li><a href="#">à rôtir </a></li>
			// 							<li><a href="#">à griller </a></li>
			// 							<li><a href="#">à braiser</a></li>
			// 							<li><a href="#">abats </a></li>
			// 						</ul>
			// 					</div>
			// 				</div>
			// 			</div><!--product 4-->
			// 		</div><!--/category-products-->
			// 	</div><!--/left-sidebar-->
			// </div><!--/colonne left-->



