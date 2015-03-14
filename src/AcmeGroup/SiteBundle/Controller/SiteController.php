<?php

namespace AcmeGroup\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use AcmeGroup\LaboBundle\Entity\demandedevis;
// classes paramètres
use AcmeGroup\LaboBundle\Classes\paramEvenement;

class SiteController extends Controller {

	//////////////////////////
	// PAGES
	//////////////////////////

	public function indexAction() {
		$this->get('acmeGroup.aelog')->createNewLogAuto();
		return $this->render($this->verifVersionPage("Site:index"));
	}

	public function homepageAction() {
		return $this->indexAction();
	}

	public function pagewebAction($categorieSlug = "web", $pagewebSlug = null, $pagedata = null) {
		$this->get('acmeGroup.aelog')->createNewLogAuto();
		// JSon décode et vérifie si c'était bien des données au format JSon (sinon les gardes telles quelles)
		$pagedata = $this->compileData($pagedata);
		// si la page appélée vient d'une catégorie (et non d'une pageweb)
		// et qu'aucune pageweb n'est précisée : on retrouve la pageweb de la catégorie
		if(($categorieSlug !== "web") && ($pagewebSlug === null)) {
			// récupération de $pagewebSlug selon $categorieSlug
			$categorie = $this->get("acmeGroup.categorie")->getRepo()->findBySlug($categorieSlug);
			if(count($categorie) > 0) {
				$pagewebSlug = $categorie[0]->getPage()->getSlug();
			} else {
				$$categorieSlug = null;
			}
		}
		return $this->dispatch($pagewebSlug, $pagedata);
	}


	public function pagemodaleAction($pagewebSlug, $pagedata = null) {
		// return new Response("<h1 class='ital'>Bonjour vous !</h1>");
		return new Response($this->dispatch($pagewebSlug, $this->compileData($pagedata), true));
	}


	protected function dispatch($pagewebSlug, $pagedata = null, $modale = null) {
		$data = array();
		$Tidx = $this->get("session")->get('version');
		$page = $this->get("acmeGroup.pageweb")->getDynPages($pagewebSlug);
		if(count($page) > 0) {
			// page existe
			reset($page);
			$data['pageweb'] = current($page);
			// orientation selon page web demandée :
			switch ($pagewebSlug) {

				case 'contact':
					$data['societe'] = $this->get("acmeGroup.version")->getRepo()->find($Tidx['id']);
					break;

				case 'actualites':
					// $pagedata = null
					// $pagedata['limit'] = nombre d'actualités demandées (null par défaut = toutes)
					// $pagedata['sens'] = 'ASC' ou 'DESC' ('DESC' par défaut)
					// *** $pagedata['datedebut'] = datetime date (null par défaut = toutes)
					// *** $pagedata['datefin'] = datetime date (null par défaut = toutes)
					$data['events'] = array();
					$limit = null;
					if(isset($pagedata['limit']) && $pagedata['limit'] !== null) {
						$limit = intval($pagedata['limit']);
					}
					$sens = 'DESC';
					if(isset($pagedata['sens'])) {
						if(in_array(strtoupper($pagedata['sens']), array("ASC", "DESC"))) {
							$sens = strtoupper($pagedata['sens']);
						}
					}
					$data['events']['futurevents'] = $this->get("acmeGroup.events")->getRepo()->findFuturs('actualites', $sens, $limit);
					// si moins de 3 résultats… retrouve les 3 actualités passées les plus récentes
					if(count($data['events']['futurevents']) < 3) {
						$data['events']['pastevents'] = $this->get("acmeGroup.events")->getRepo()->findPasses('actualites', 'DESC', 3);
					}
					break;

				case 'un-evenement':
					// $pagedata = slug de l'évènement
					$event = $this->get("acmeGroup.events")->getRepo()->findBySlug($pagedata);
					if(count($event) > 0) {
						reset($event);
						$data["event"] = current($event);
					} else $data["event"] = false;
					break;

				case 'nos-partenaires':
					$data["partenaires"] = $this->get("acmeGroup.entities")->defineEntity('partenaire')->getRepo()->findAll();
					break;

				case 'un-partenaire':
					// $pagedata = slug du partenaire
					$part = $this->get("acmeGroup.entities")->defineEntity('partenaire')->getRepo()->findBySlug($pagedata);
					if(count($part) > 0) {
						reset($part);
						$data["partenaire"] = current($part);
					} else $data["partenaire"] = false;
					break;
				
				default:
					// pages par défaut / Dont celles qui n'ont pas besoin de données
					break;
			}
		} else {
			// page n'existe pas => no-page
			$page = $this->get("acmeGroup.pageweb")->getDynPages("no-page");
			$data['pageweb'] = $page[0];
		}
		if($modale === true) {
			// Traitement en modale
			// on change le dossier d'origine du template par le dossier "fancy"
			$data["modale"] = true;
			// $file = explode(':', $this->verifVersionPage($data['pageweb']->getFichierhtml()), 2);
			// if(count($file) > 1) $twigfile = "fancy:".$file[1];
			// 	else $twigfile = "fancy:".$file[0];
			$twigfile = str_replace("pageweb:", "fancy:", $this->verifVersionPage($data['pageweb']->getFichierhtml()));
			return $this->renderView($twigfile, $data);
		} else {
			// Traitement normal entête HTML
			$data["modale"] = false;
			return $this->render($this->verifVersionPage($data['pageweb']->getFichierhtml()), $data);
		}
	}

	/**
	 * compile les données $pagedata passées dans pageweb (ou pagemodale)
	 * @param string $pagedata
	 * @return string/array selon le type de données
	 */
	private function compileData($pagedata) {
		$pd = json_decode($pagedata, true);
		if($pd !== null) $pagedata = $pd;
		return $pagedata;
	}

	//////////////////////////
	// BLOCS
	//////////////////////////

	public function menuAction($template = "menuPpal") {
		// génération de la page
		return $this->render($this->verifVersionPage("menu:".$template));
	}

	public function carrousselAction($collection = null) {
		$data['carroussel'] = $this->get('acmeGroup.collection')->getDiaporama($collection);
		// génération de la page
		return $this->render($this->verifVersionPage("blocs:carroussel"), $data);
	}

	public function newshomeAction($date = null) {
		$ent = $this->get('acmeGroup.events');
		$data['newshome'] = $ent->getNewshome($date);
		// génération de la page
		return $this->render($this->verifVersionPage("blocs:newshome"), $data);
	}

	public function boutondonAction($date = null) {
		// génération de la page
		return $this->render($this->verifVersionPage("blocs:boutondon"));
	}



	//////////////////////////
	// RSS
	//////////////////////////

	public function getRssAction() {
		$data["evenement"] = $this->get('acmeGroup.events')->getNEventsByType(array("actions"), 1000, false);
		$xmlContent = $this->renderView("AcmeGroupSiteBundle:rss:flux001.xml.twig", $data);
		$response = new Response($xmlContent);
		$response->headers->set('Content-Type', 'xml');
		return $response;
	}

	public function generateRss() {
		$data = array();
		$rss = $this->renderView("AcmeGroupSiteBundle:rss:flux001.xml.twig", $data);
		$f = fopen("/web/images/testfichier.rss", "a");
		fwrite($f, $rss);
		fclose($f);
	}


	//////////////////////////
	// Autres fonctions
	//////////////////////////

	private function recupVersion() {
		$Tidx = $this->get("session")->get('version');
		if($Tidx["templateIndex"] === null) $Tidx["templateIndex"] = "Site";
		return $Tidx;
	}

	private function verifVersionPage($page) {
		$p = explode(":", $page, 2);
		if(count($p) > 1) {
			$Tidx["templateIndex"] = $p[0];
			$page = $p[1];
		} else {
			$Tidx = $this->recupVersion();
		}
		if(!$this->get('templating')->exists("AcmeGroupSiteBundle:".$Tidx["templateIndex"].":".$page.".html.twig")) {
			// si la page n'existe pas, on prend le template de la version par défaut
			$Tidx["templateIndex"] = $this->get("acmeGroup.version")->getDefaultVersionDossTemplates();
		}
		return "AcmeGroupSiteBundle:".$Tidx["templateIndex"].":".$page.".html.twig";
	}


}



