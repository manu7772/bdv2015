<?php
// src/AcmeGroup/SiteBundle/Classes/menuOptions.php

namespace AcmeGroup\SiteBundle\Classes;

class menuOptions {

	// protected $routesForCategories = array('acme_site_categories');
	protected $container;

	public function __construct($container) {
		$this->container = $container;
	}

	public function getOptions($pagesWeb = null) {
		$router = $this->container->get('router');
		$categorie = $this->container->get('AcmeGroup.categorie');
		$levelno = 0;
		$categorieSlug = $this->container->get("request")->attributes->get('categorieSlug');
		// if($categorieSlug === "web") $categorieSlug = null;
		$c = $this->container->get('session')->get('version');
		$couleur = $c["couleur"];
		return array(
			'decorate' => true,
			'rootOpen' => function($tree) use ($levelno) {
				if(count($tree[0]['__children']) > 0) $childs = true; else $childs = false;
				// echo('<pre>');var_dump($tree);echo('</pre>');
				$r = null;
				switch($tree[0]['lvl']) {
					case $levelno:
						$r = '<div id="menuflexi" class="content">
';
						break;
					case $levelno+1:
						$r = '	<ul class="flexy-menu bleu">
';
						break;
					default:
						$r = '		<ul>
';
						break;
				}
				return $r;
			},
			'rootClose' => function($tree) use ($levelno) {
				$r = null;
				switch($tree[0]['lvl']) {
					case $levelno:
						$r = '	</ul>
</div>
';
						break;
					default:
						$r = '		</ul>
';
						break;
				}
				return $r;
			},
			'childOpen' => function($child) use ($levelno, $categorieSlug) {
				$r = null;
				// if(count($child['__children']) > 0) $childs = true; else $childs = false;
				$descr = '';
				if($child['slug'] === $categorieSlug) $descr = ' class="active"'; else $descr = '';
				$child['descriptif'] = trim($child['descriptif']);
				if($child['descriptif'] !== null || $child['descriptif'] !== "") $descr .= ' title="'.$child['descriptif'].'"';
				switch($child['lvl']) {
					case $levelno:
						$r = null;
						break;
					default:
						$r = '		<li'.$descr.'>
';
						break;
				}
				return $r;
			},
			'childClose' => function($child) use ($levelno) {
				$r = null;
				// if(count($child['__children']) > 0) $childs = true; else $childs = true;
				switch($child['lvl']) {
					case $levelno:
						$r = null;
						break;
					default:
						$r = '		</li>
';
						break;
				}
				return $r;
			},
			'nodeDecorator' => function($node) use ($router, $levelno, $categorie) {
				$r = null;

				$cat = $categorie->getRepo()->findBySlug($node["slug"]);
				if(count($cat) > 0) {
					$pagewebSlug = $cat[0]->getPage()->getSlug();
					$routeParam = $cat[0]->getPage()->getRoute();
					$Url = $router->generate($routeParam, array(/*"pagewebSlug" => $pagewebSlug,*/ "categorieSlug" => $node['slug']));
				} else $Url = $router->generate("acme_site_home");

				switch($node['lvl']) {
					case $levelno:
						$r = null;
						break;
					default:
						$r = '			<a href="'.$Url.'" >'.$node["nom"].'</a>
';
						break;
				}
				return $r;
			}
		);
	}
}






?>