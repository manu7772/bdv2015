<?php

namespace AcmeGroup\UserBundle\Entity;

use Doctrine\ORM\EntityRepository;
// use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository {

	const ELEMENT = 'element';

	protected $em;
	protected $versionSlug = null;
	// valeurs possibles :
	// null = version par défaut (defaultVersion = true)
	// false = pas de test de version
	// string = slug de la version à recherche


	/** Renvoie la(les) valeur(s) par défaut --> ATTENTION : dans un array()
	* @param $defaults = liste des éléments par défaut
	*/
	public function defaultVal($defaults = null) {
		if($defaults === null) $defaults = array("sadmin");
		$qb = $this->getQbWithDefaultVersion();
		$qb->where($qb->expr()->in(self::ELEMENT.'.username', $defaults));
		return $qb->getQuery()->getResult();
	}

	/**
	 * getEditors
	 * Récupère les utilisateurs habilités à accéder à l'interface d'admin (à partir de EDITOR)
	 */
	public function getEditors() {
		$this->qb = $this->getEditorsAndMore();
		return $this->qb->getQuery()->getResult();
	}

	/**
	 * setVersion
	 * fixe la version du site pour le repository
	 * si $version n'est pas précisé, recherche la version par défaut dans l'entité AcmeGroup\LaboBundle\Entity\version
	 * @param string $version
	 * @param string $shutdown
	 */
	// public function setVersion($version = null, $shutdown = null) {
	// 	if($version === null) {
	// 		$ver = $this->_em->getRepository("AcmeGroupLaboBundle:version")->defaultVersion();
	// 		$this->version = $ver->getSlug();
	// 	} else if(is_array($version)) {
	// 		$this->version = $version;
	// 	} else if(is_string($version)) {
	// 		$this->version = array($version);
	// 	}
	// 	if($shutdown !== null) $this->version = null;
	// 	return $this;
	// }

	/**
	 * dontTestVersion
	 * Annule le test de version
	 */
	// public function dontTestVersion() {
	// 	$this->version = false;
	// 	return $this;
	// }

	/**
	 * getFields
	 * Liste les champs de l'entité
	 */
	// public function getFields() {
	// 	$r = array();
	// 	$qb = $this->createQueryBuilder('element')
	// 		->setMaxResults(1);
	// 	$a = $qb->getQuery()->getArrayResult();
	// 	foreach($a as $nom1 => $val1)
	// 		foreach($val1 as $nom2 => $val2) $r[] = $nom2;
	// 	return $r;
	// }

	/**
	 * findUserPagination
	 * Recherche les Users en fonction de la version
	 * et pagination avec GET
	 */
	public function findUserPagination($role = 'tous-roles', $page = 1, $lignes = null, $ordre = 'id', $sens = 'ASC', $searchString = null, $searchField = "username") {
		// vérifications pagination
		if($page < 1) $page = 1;
		if($lignes > 100) $lignes = 100;
		if($lignes < 10) $lignes = 10;
		// Requête…
		$qb = $this->getQbWithDefaultVersion();
		switch ($role) {
			case 'tous-roles':
				break;
			case 'ROLE_USER':
				$qb->where(self::ELEMENT.'.roles LIKE :role')
					->setParameter('role', "a:0:{}");
				break;
			default:
				$qb->where(self::ELEMENT.'.roles LIKE :role')
					->setParameter('role', "%".serialize($role)."%");
				break;
		}
		$qb = $this->rechercheStr($qb, $searchString, $searchField);
		if(!in_array($ordre, $this->getFields())) $ordre = "id";
		if(!in_array($sens, array('ASC', 'DESC'))) $sens = "ASC";
		$qb->orderBy(self::ELEMENT.'.'.$ordre, $sens);
		// Pagination
		$qb->setFirstResult(($page - 1) * $lignes)
			->setMaxResults($lignes);
		return new Paginator($qb);
	}

	/***************************************************************/
	/*** Méthodes conditionnelles
	/***************************************************************/

	/**
	* defaultStatut
	* Sélect article de statut = actif uniquement
	*
	*/
	// protected function defaultStatut(\Doctrine\ORM\QueryBuilder $qb, $statut = null) {
	// 	if($statut == null) $statut = array("Actif");
	// 	if(is_string($statut)) $statut = array($statut);
	// 	$qb->join('element.statut', 'stat')
	// 		->andWhere($qb->expr()->in('stat.nom', $statut));
	// 	return $qb;
	// }

	/**
	* withVersion
	* Sélect article de version = $version uniquement (slug)
	*
	*/
	// protected function withVersion(\Doctrine\ORM\QueryBuilder $qb, $version = null) {
	// 	if($this->version !== false) {
	// 		if($version !== null) $this->setVersion($version);
	// 		$version = $this->version;
	
	// 		$qb->join('element.versions', 'ver')
	// 			->andWhere($qb->expr()->in('ver.slug', $version));
	// 	}
	// 	return $qb;
	// }

	/**
	* excludeExpired
	* Sélect articles non expirés
	*
	*/
	// protected function excludeExpired(\Doctrine\ORM\QueryBuilder $qb) {
	// 	$qb->andWhere('element.dateExpiration > :date')
	// 		->orWhere('element.dateExpiration is null')
	// 		->setParameter('date', new \Datetime());
	// 	return $qb;
	// }

	/**
	* rechercheStr
	* trouve les éléments qui contiennent la chaîne $searchString
	*
	*/
	// protected function rechercheStr(\Doctrine\ORM\QueryBuilder $qb, $searchString, $searchField = null, $mode = null) {
	// 	if($searchField === null) {
	// 		$priori = array("username");
	// 		$firstField = $this->getFields();
	// 		foreach($priori as $field) if(in_array($field, $firstField)) $searchField = $field;
	// 		if ($searchField === null) $searchField = $firstField[1];
	// 	}
	// 	switch ($mode) {
	// 		case 'begin':
	// 			$bef = "";
	// 			$aft = "%";
	// 			break;
	// 		case 'end':
	// 			$bef = "%";
	// 			$aft = "";
	// 			break;
	// 		case 'exact':
	// 			$bef = $aft = "";
	// 			break;
	// 		default:
	// 			$bef = $aft = "%";
	// 			break;
	// 	}
	// 	if(is_string($searchString) && $searchString !== "") {
	// 		$qb->where($qb->expr()->like('element.'.$searchField, $qb->expr()->literal($bef.$searchString.$aft)));
	// 	}
	// 	return $qb;
	// }

	/**
	 * getEditorsAndMore
	 * Récupère les utilisateurs habilités à accéder à l'interface d'admin (à partir de EDITOR)
	 */
	public function getEditorsAndMore() {
		$qb = $this->getQbWithDefaultVersion();
		$this->qb->where(self::ELEMENT.'.roles LIKE :roleE')
			->setParameter('roleE', "%".serialize('ROLE_EDITOR')."%");
		$this->qb->orWhere(self::ELEMENT.'.roles LIKE :roleA')
			->setParameter('roleA', "%".serialize('ROLE_ADMIN')."%");
		$this->qb->orWhere(self::ELEMENT.'.roles LIKE :roleS')
			->setParameter('roleS', "%".serialize('ROLE_SUPER_ADMIN')."%");
		return $this->qb;
	}

	/**
	 * Définit la version à utiliser pour les requêtes
	 * @param string $versionSlug
	 * @return QueryBuilder
	 */
	public function setVersion($versionSlug = null) {
		$this->versionSlug = $versionSlug;
	}

	/**
	 * filtre la version à utiliser par défaut dans le qb
	 * @param QueryBuilder $qb
	 * @return QueryBuilder
	 */
	protected function getQbWithDefaultVersion(QueryBuilder $qb = null) {
		if(!($qb instanceOf QueryBuilder)) $qb = $this->createQueryBuilder(self::ELEMENT);
		// if($this->versionSlug === false) return $qb;
		if($this->versionSlug === null) {
			$qb->where(self::ELEMENT.'.defaultVersion = :true')
				->setParameter('true', 1);
		}
		if(is_string($this->versionSlug)) {
			$qb->where(self::ELEMENT.'.slug = :version')
				->setParameter('version', $this->versionSlug);
		}
		return $qb;
	}

}
