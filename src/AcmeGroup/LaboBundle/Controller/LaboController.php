<?php

namespace AcmeGroup\LaboBundle\Controller;

use labo\Bundle\TestmanuBundle\Controller\LaboController as LaboCtrl;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class LaboController extends LaboCtrl {

	// Page d'accueil de l'admin (labo)
	public function homeAction() {
		return $this->render('AcmeGroupLaboBundle:pages:index.html.twig');
	}

	public function jumbotronAction() {
		return $this->render('AcmeGroupLaboBundle:bloc:jumbotron.html.twig');
	}

	public function jumbotronworkingAction() {
		return $this->render('AcmeGroupLaboBundle:bloc:jumbotronworking.html.twig');
	}

	public function navbarAction($pageweb = null) {
		if($pageweb !== null) {
			$data["pageweb"] = $this->container->get('acmeGroup.pageweb')->getDynPages($pageweb);
		} else {
			$data["pageweb"] = null;
		}
		$data['entity']['typeRichtext'] = $this->get('acmeGroup.texttools')->typeRichtextList();
		$data['entity']['typeEvenement'] = $this->get('acmeGroup.entities')->defineEntity('typeEvenement')->getRepo()->findAll();
		$data['entity']['typePartenaire'] = $this->get('acmeGroup.entities')->defineEntity('typePartenaire')->getRepo()->findAll();
		return $this->render(':common:navbar.html.twig', $data);
	}

	/**
	 * imagesVersionAction
	 * Ajoute les images d'entête de la version (pour l'instant impossible par fixtures)
	 */
	public function imagesVersionAction() {
		$em = $this->getDoctrine()->getManager();
		$repoImg = $em->getRepository("AcmeGroupLaboBundle:image");
		$repoVer = $em->getRepository("AcmeGroupLaboBundle:version");
		$repoAdr = $em->getRepository("AcmeGroupLaboBundle:adresse");
		$data["images_wide"] = array(
			"model"		=> array($repoVer, $repoImg, "setImageEnteteWide"),
			"liste"		=> array(
				array("Rayon de Soleil", "enteteRDS_wide"),
				array("Sonnenschein", "enteteSNC_wide")
				)
			);
		$data["images_Medi"] = array(
			"model"		=> array($repoVer, $repoImg, "setImageEnteteMedi"),
			"liste"		=> array(
				array("Rayon de Soleil", "enteteRDS_wide"),
				array("Sonnenschein", "enteteSNC_wide")
				)
			);
		$data["images_Mini"] = array(
			"model"		=> array($repoVer, $repoImg, "setImageEnteteMini"),
			"liste"		=> array(
				array("Rayon de Soleil", "enteteRDS_mini"),
				array("Sonnenschein", "enteteSNC_wide")
				)
			);
		$data["favicons"] = array(
			"model"		=> array($repoVer, $repoImg, "setFavicon"),
			"liste"		=> array(
				array("Rayon de Soleil", "faviconRDS"),
				array("Sonnenschein", "faviconSNC")
				)
			);
		$data["adresses"] = array(
			"model"		=> array($repoVer, $repoAdr, "setAdresse"),
			"liste"		=> array(
				array("Rayon de Soleil", "Rayon de Soleil"),
				array("Sonnenschein", "Sonnenschein")
				)
			);
		// IMAGES
		foreach($data as $nom => $elem) {
			$cpt = 0;$echec = 0;
			foreach($elem["liste"] as $ligne => $item) {
				$i = $elem["model"][1]->findByNom($item[1]);
				$v = $elem["model"][0]->findByNom($item[0]);
				if(is_object($v[0]) && is_object($i[0])) {
					$method = $elem["model"][2];
					$v[0]->$method($i[0]);
					$em->persist($v[0]);
					$cpt++;
				} else $echec++;
			}
			$this->get('session')->getFlashBag()->add("info", $cpt." ".$nom." ajouté(es) / ".$echec." échec");
		}
		$em->flush();
		$Tidx = $this->get("session")->get('version');
		return $this->redirect($this->generateUrl("acme_site_home", array("versionDefine" => $Tidx["slug"])));
	}
}