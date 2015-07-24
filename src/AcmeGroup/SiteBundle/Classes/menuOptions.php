<?php
// src/AcmeGroup/SiteBundle/Classes/menuOptions.php

namespace AcmeGroup\SiteBundle\Classes;

use laboBundle\services\entitiesServices\categorie;

class menuOptions {

	// protected $routesForCategories = array('acme_site_categories');
	protected $container;

	public function __construct($container) {
		$this->container = $container;
	}

	public function getOptions($pagesWeb = null) {
		$router = $this->container->get('router');
		$categorie = $this->container->get('labobundle.categorie');
		$repo = $categorie->getRepo('categorie');
		$levelno = 0;
		$categorieSlug = $this->container->get("request")->attributes->get('categorieSlug');
		// if($categorieSlug === "web") $categorieSlug = null;
		// $c = $this->container->get('session')->get('version');
		// $couleurFond = $c["couleurFond"];
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
			'nodeDecorator' => function($node) use ($router, $levelno, $repo) {
				$r = null;

				$cat = $repo->findOneBySlug($node["slug"]);
				if(is_object($cat)) {
					// $pagewebSlug = $cat->getPage()->getSlug();
					$Url = $router->generate(
						$cat->getPage()->getRoute(),
						array(/*"pagewebSlug" => $pagewebSlug,*/ "categorieSlug" => $node['slug'])
					);
				} else $Url = $router->generate("acme_site_home");

				switch($node['lvl']) {
					case $levelno:
						$r = null;
						break;
					default:
						$r = '<div class="panel-heading">
	<h4 class="panel-title">
		<a data-toggle="collapse" data-parent="#accordian" href="'.$Url.'">
			<span class="badge pull-right"><i class="fa fa-plus"></i></span>
			'.$node["nom"].'
		</a>
	</h4>
</div>';
						// $r = '			<a href="'.$Url.'" >'.$node["nom"].'</a>';
						break;
				}
				return $r;
			}
		);
	}
}






?>