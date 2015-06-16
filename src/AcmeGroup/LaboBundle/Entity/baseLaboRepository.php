<?php

namespace AcmeGroup\LaboBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\QueryBuilder;

use \Exception;
use \DateTime;

use AcmeGroup\LaboBundle\Entity\version;
use AcmeGroup\LaboBundle\Entity\statut;

/**
 * baseLaboRepository
 */
class baseLaboRepository extends EntityRepository {

	const ELEMENT					= 'element';
	const CHAMP_DEFAULT				= "id";
	const CHAMP_DATE_CREATION 		= "dateCreation";
	const CHAMP_DATE_EXPIRATION 	= "dateExpiration";
	const CHAMP_DATE_PUBLICATION	= "datePublication";
	const CHAMP_DATE_DEBUT			= "dateDebut";
	const CHAMP_DATE_FIN			= "dateFin";

	const VERSION_CLASS_NAME		= "AcmeGroup\\LaboBundle\\Entity\\version";

	protected $version 				= false;
	protected $fields 				= array();
	protected $initCMD 				= false;
	protected $ClassMetadata;

	public function __construct(EntityManager $_em, ClassMetadata $ClassMetadata) {
		$this->ClassMetadata = $ClassMetadata;
		parent::__construct($_em, $this->ClassMetadata);
		$this->defineClassMetaData();
		$this->initDefaultVersion();
		// printf("Version defined…\n");
	}

	/** 
	 * Renvoie la(les) valeur(s) par défaut
	 * $onlyOneObject : si true, renvoie un seul objet en résultat, ou null - false, renvoie un tableau (vide si aucun)
	 * @param mixed $defaults - valeur(s) à rechercher dans le $champ
	 * @param boolean $onlyOneObject
	 * @param string $champ - 'nom' par défaut
	 * @return mixed
	 */
	public function defaultVal($defaults = null, $onlyOneObject = false, $champ = 'nom') {
		$champ = $this->getDefaultFieldIfNotFound($champ);
		// recherche
		$qb = $this->createQueryBuilder(self::ELEMENT);
		if(is_string($defaults)) $defaults = array($defaults);
		if(is_array($defaults)) if(count($defaults) < 1) $defaults = nulll;
		if($defaults !== null) $qb->where($qb->expr()->in(self::ELEMENT.'.'.$champ, $defaults));
		if($onlyOneObject === true) {
			try { $result = $qb->getQuery()->getSingleResult(); }
			catch (Exception $e) { $result = null; }
		} else $result = $qb->getQuery()->getResult();
		return $result;
	}

	/** 
	 * Renvoie la(les) valeur(s) selon le(s) ROLE(S) --> ATTENTION : retourne un queryBuilder
	 * @param mixed $roles
	 * @param string $champ - 'nom' par défaut
	 * @return queryBuilder
	 */
	public function defaultRoleClosure($roles = null, $champ = 'nom') {
		$champ = $this->getDefaultFieldIfNotFound($champ);
		if($roles === null) $roles = array('ROLE_USER');
		if(is_string($roles)) $roles = array($roles);
		$list = array();
		foreach($roles as $role) {
			switch($role) {
				case "ROLE_EDITOR":
					// $list = array_merge($list, array("Actif", "Inactif"));
					break;
				case "ROLE_USER":
					// $list = array_merge($list, array("Actif", "Inactif"));
					break;
				case "ROLE_ADMIN":
					// $list = array_merge($list, array("Actif", "Inactif"));
					break;
				case "ROLE_SUPER_ADMIN":
					// $list = array();
					break 2;
				default:
					// $list = array_merge($list, array("Actif", "Inactif"));
					break;
			}
		}
		$qb = $this->createQueryBuilder(self::ELEMENT);
		if(is_array($list) && count($list) > 0) $qb->where($qb->expr()->in(self::ELEMENT.'.'.$champ, array_unique($list)));
		return $qb;
	}

	/**
	 * Renvoie le nom de l'entité parent
	 * @return string
	 */
	public function getParentClassName() {
		return get_parent_class();
	}

	/**
	 * Renvoie le nom de l'entité parent
	 * @return string
	 */
	public function getParentshortName() {
		return $this->getSimpleNameFromString($this->getParentClassName());
	}

	/**
	 * Renvoie le nom de l'entité
	 * @return string
	 */
	public function getClassName() {
		return get_called_class();
	}

	/**
	 * Renvoie le nom de l'entité
	 * @return string
	 */
	public function getName() {
		return $this->getSimpleNameFromString($this->getClassName());
	}

	/**
	 * Renvoie le nom court de l'entité
	 * @param string $longName
	 * @return string
	 */
	public function getSimpleNameFromString($longName) {
		if($longName === false) return $longName;
		$longName = explode(self::SLASH, $longName);
		return end($longName);
	}

	/**
	 * Renvoie une représentation texte de l'objet.
	 * @return string
	 */
	public function __toString() {
		return __CLASS__.'@'.spl_object_hash($this);
	}

	/**
	 * defineClassMetaData
	 */
	protected function defineClassMetaData() {
		if($this->initCMD === false) {
			$this->initCMD = true;
			// ajout champs single
			$fields = $this->ClassMetadata->getFieldNames();
			foreach($fields as $field) {
				$this->fields[$field]['nom'] = $field;
				$this->fields[$field]['association'] = null;
				if($this->ClassMetadata->hasAssociation($field)) {
					if($this->ClassMetadata->isCollectionValuedAssociation($field))
						$this->fields[$field]['association'] = 'collection';
					if($this->ClassMetadata->isAssociationWithSingleJoinColumn($field))
						$this->fields[$field]['association'] = 'single';
				}
				$this->fields[$field]['type'] = $this->ClassMetadata->getTypeOfField($field);
				$this->fields[$field]['ID'] = $this->ClassMetadata->isIdentifier($field);
			}
			// affichage
			// echo("<pre>");print_r($this->fields);echo("</pre>");
		}
	}

	/**
	 * Définit la version du site à utiliser pour le repository. 
	 * si $version n'est pas précisé, recherche la version par défaut dans l'entité AcmeGroup\LaboBundle\Entity\version
	 * @param version $version
	 * @return baseLaboRepository
	 */
	public function setVersion($version = null, $force = false) {
		$this->version = false;
		// echo('REPO : Demande de version : '.$version.'<br>');
		// version par défaut
		if($version === null) {
			$version = $this->_em->getRepository(self::VERSION_CLASS_NAME)->defaultVersion();
			if(is_array($version)) {
				if(count($version) > 0) {
					$ver = reset($version);
					$this->version = $ver->getSlug();
				}
			}
		}
		// version en données de session
		if(is_string($version) && strlen(trim($version)) > 0) {
			$this->version = $version;
		}
		// objet version
		if($version instanceOf version) {
			$this->version = $version->getSlug();
		} 
		// echo('REPO : Définition de version : '.$this->version.'<br>');
		return $this;
	}

	public function initDefaultVersion() {
		return $this->setVersion();
	}

	/**
	 * Renvoie la version utilisé par le repository
	 * @return version
	 */
	public function getVersion() {
		return $this->version;
	}

	/**
	 * Liste les champs de l'entité
	 * @return array
	 */
	public function getFields() {
		return $this->fields;
	}

	/**
	 * Vérifie si un champ existe
	 * @param string $field
	 * @return boolean
	 */
	public function field_exist($field) {
		return array_key_exists($field, $this->getFields());
	}

	/**
	 * Renvoie le même champ $field s'il existe, sinon renvoie le champ par défaut (CHAMP_DEFAULT)
	 * @param string $field
	 * @return string
	 */
	public function getDefaultFieldIfNotFound($field) {
		return $this->field_exist($field) ? $field : self::CHAMP_DEFAULT;
	}

	/**
	 * Renvoie les entités dont le $champ contient les valeurs $values
	 * @param string $champ
	 * @param array $values
	 * @return array
	 */
	public function findByAttrib($champ, $values) {
		if($this->field_exist($champ)) {
			if(is_string($values)) $values = array($values);
			$qb = $this->createQueryBuilder(self::ELEMENT);
			$qb->where($qb->expr()->in(self::ELEMENT.'.'.$champ, $values));
			return $qb->getQuery()->getResult();
		} else {
			throw new Exception("Repository : ce champ n'existe pas.");
		}
	}






	/**
	 * findXrandomElements
	 * récupère $n éléments au hasard dans la BDD
	 * @param integer $n
	 * @return array
	 */
	public function findXrandomElements($X) {
		$X = intval($X);
		if($X < 1) $X = 1;
		$qb = $this->createQueryBuilder(self::ELEMENT);
		$qb = $this->defaultStatut($qb);
		// $qb = $this->excludeExpired($qb);
		$qb = $this->withVersion($qb);
		// $qb->setMaxResults($X);
		$r = $qb->getQuery()->getResult();
		if($X > count($r)) $X = count($r);
		shuffle($r);
		$rs = array();
		for ($i=0; $i < $X ; $i++) { 
			$rs[] = $r[$i];
		}
		return $rs;
	}

	/**
	 * findElementsPagination
	 * Recherche les elements en fonction de la version
	 * et pagination avec GET
	 */
	// public function findElementsPagination($page = 1, $lignes = null, $ordre = 'id', $sens = 'ASC', $searchString = null, $searchField = "nom") {
	public function findElementsPagination($pag, $souscat = null) {
		// vérifications pagination
		if($pag['page'] < 1) $pag['page'] = 1;
		if($pag['lignes'] > 100) $pag['linges'] = 100;
		if($pag['lignes'] < 10) $pag['lignes'] = 10;
		// Requête…
		$qb = $this->createQueryBuilder(self::ELEMENT);
		$qb = $this->rechercheStr($qb, $pag['searchString'], $pag['searchField']);
		// sous-catégories de tri
		if($souscat !== null) {
			$qb->join(self::ELEMENT.'.'.$souscat['attrib'], 'link')
				->andWhere($qb->expr()->in('link.'.$souscat['column'], explode(":", $souscat['values'])));
		}
		// $qb->leftJoin(self::ELEMENT.'.imagePpale', 'i')
		// 	->addSelect('i')
		// 	->leftJoin(self::ELEMENT.'.images', 'ii')
		// 	->addSelect('ii')
		// 	->leftJoin(self::ELEMENT.'.reseaus', 'r')
		// 	->addSelect('r');
		// exclusions
		// $qb = $this->excludeExpired($qb);
		$qb = $this->withVersion($qb);
		// $qb = $this->defaultStatut($qb);
		// Tri/ordre
		if(!in_array($pag['ordre'], $this->getFields())) $pag['ordre'] = "id";
		if(!in_array($pag['sens'], array('ASC', 'DESC'))) $pag['sens'] = "ASC";
		$qb->orderBy(self::ELEMENT.'.'.$pag['ordre'], $pag['sens']);
		// Pagination
		$qb->setFirstResult(($pag['page'] - 1) * $pag['lignes'])
			->setMaxResults($pag['lignes']);
		return new Paginator($qb);
	}


	/**
	 * Sélectionne les éléments comportant le(s) $tag(s) en paramètre
	 * @param mixed $tags
	 */
	public function findListByTags($tags, pagine $pagine = null) {
		if(is_string($tags)) $tags = array($tags);
		if(is_array($tags)) {
			$qb = $this->createQueryBuilder(self::ELEMENT);
			$qb->join(self::ELEMENT.'.tags', 'tag')
				->where($qb->expr()->in('tag.slug', $tags))
				// ->orderBy(self::ELEMENT.".id", "ASC")
			;
		} else {
			throw new Exception("Repository : tags incorrects. Type <i>".gettype($tags)."</i> inattendu.");
		}
		return $qb->getQuery()->getResult();
	}


	/***************************************************************/
	/*** Méthodes conditionnelles / manipulation du QueryBuilder
	/***************************************************************/

	/**
	 * Sélect element de statut/expirés/version
	 * @param QueryBuilder $qb
	 * @return QueryBuilder
	 */
	protected function genericFilter(QueryBuilder $qb, $statut = null, $published = true, $expired = true, $version = null) {
		$qb = $this->defaultStatut($qb, $statut);
		$qb = $this->withVersion($qb, $version);
		if($expired === true) $qb = $this->excludeExpired($qb);
		if($published === true) $qb = $this->excludeNotPublished($qb);
		return $qb;
	}

	/**
	 * defaultStatut
	 * Sélect element de statut = actif uniquement
	 * @param QueryBuilder $qb
	 * @param array/string $statut
	 * @return QueryBuilder
	 */
	protected function defaultStatut(QueryBuilder $qb, $statut = null) {
		if($this->field_exist("statut")) {
			if($statut === null) $statut = array("Actif");
			if(is_string($statut)) $statut = array($statut);
			$qb->join(self::ELEMENT.'.statut', 'stat')
				->andWhere($qb->expr()->in('stat.nom', $statut));
		}
		return $qb;
	}

	/**
	 * Sélect element de $version uniquement
	 * @param QueryBuilder $qb
	 * @param mixed $version
	 * @return QueryBuilder
	 */
	protected function withVersion(QueryBuilder $qb, $version = null) {
		if($this->field_exist("version")) {
			if($this->version !== false || $version !== null) {
				if($version === null) $version = $this->version;
				$version = $this->version;
				echo('Version : '.$version.'<br>');
				$qb->join(self::ELEMENT.'.version', 'ver')
					->andWhere($qb->expr()->in('ver.slug', $version));
			}
		}
		return $qb;
	}

	/**
	 * jointures leftJoin d'après un array
	 * @param QueryBuilder $qb
	 * @param array $adds
	 * @param string $champ
	 * @return QueryBuilder
	 */
	protected function addJoins(QueryBuilder $qb, $adds, $joined = null) {
		if($joined === null || !is_string($joined)) $joined = self::ELEMENT;
		if(!($qb instanceOf QueryBuilder)) $qb = $this->createQueryBuilder($joined);
		if(is_array($adds)) foreach ($adds as $field => $childs) {
			$itemField = $joined.'.'.$field;
			if(!is_array($childs)) $childs = array();
			$qb->leftJoin($itemField, $joined.$field)
				->addSelect($joined.$field)
				;
			if(count($childs) > 0) $qb = $this->addJoins($qb, $childs, $joined.$field);
		}
		return $qb;
	}

	/**
	 * excludeExpired
	 * Sélect elements non expirés
	 * @param QueryBuilder $qb
	 * @return QueryBuilder
	 */
	protected function excludeExpired(QueryBuilder $qb) {
		if($this->field_exist(self::CHAMP_DATE_EXPIRATION)) {
			$qb->andWhere(self::ELEMENT.'.'.self::CHAMP_DATE_EXPIRATION.' > :date OR '.self::ELEMENT.'.'.self::CHAMP_DATE_EXPIRATION.' is null')
				->setParameter('date', new DateTime());
		}
		return $qb;
	}

	/**
	 * excludeNotPublished
	 * Sélect elements publiés
	 * @param QueryBuilder $qb
	 * @return QueryBuilder
	 */
	protected function excludeNotPublished(QueryBuilder $qb) {
		if($this->field_exist(self::CHAMP_DATE_PUBLICATION)) {
			$qb->andWhere(self::ELEMENT.'.'.self::CHAMP_DATE_PUBLICATION.' < :date OR '.self::ELEMENT.'.'.self::CHAMP_DATE_PUBLICATION.' is null')
				->setParameter('date', new DateTime());
		}
		return $qb;
	}

	/**
	 * Renvoie les éléments dont les dates de création (ou autres) sont situées entre $debut et $fin
	 * @param QueryBuilder $qb
	 * @param DateTime $debut
	 * @param DateTime $fin
	 * @param string $champ
	 * @param string $champ2
	 * @return queryBuilder
	 */
	protected function betweenDates(QueryBuilder $qb, $debut, $fin, $champ = null) {
		// champ par défaut
		if($champ === null) $champ = self::CHAMP_DATE_CREATION;
		$champ = $this->getDefaultFieldIfNotFound($champ);
		// préparations dates
		$tempDates['debut'] = $debut;
		$tempDates['fin'] = $fin;
		foreach($tempDates as $nom => $date) {
			if(is_string($date)) $dates[$nom] = new DateTime($date);
			if(is_object($date)) $dates[$nom] = $date;
		}
		if(array_key_exists($champ, $this->getFields()) && is_object($dates['debut']) && is_object($dates['fin'])) {
			$qb->andWhere(self::ELEMENT.'.'.$champ.' BETWEEN :debut AND :fin')
				->setParameter('debut', $dates['debut'])
				->setParameter('fin', $dates['fin'])
				;
		}
		return $qb;
	}

	protected function beetweenDatesEvent(QueryBuilder $qb, $debut, $fin) {
		$qb = $this->betweenDates($qb, $debut, $fin, self::CHAMP_DATE_DEBUT);
		return $qb;
	}

	/**
	 * rechercheStr
	 * trouve les éléments qui contiennent la chaîne $searchString
	 *
	 */
	protected function rechercheStr(QueryBuilder $qb, $searchString, $searchField = null, $mode = null) {
		if($searchField === null) {
			$priori = array("nom", "nomunique", "fichierNom");
			$firstField = $this->getFields();
			foreach($priori as $field) if(array_key_exists($field, $firstField)) $searchField = $field;
			if ($searchField === null) $searchField = $firstField[1]['nom'];
		}
		switch ($mode) {
			case 'begin':
				$bef = "";
				$aft = "%";
				break;
			case 'end':
				$bef = "%";
				$aft = "";
				break;
			case 'exact':
				$bef = $aft = "";
				break;
			default:
				$bef = $aft = "%";
				break;
		}
		if(is_string($searchString) && $searchString !== "") {
			$qb->where($qb->expr()->like(self::ELEMENT.'.'.$searchField, $qb->expr()->literal($bef.$searchString.$aft)));
		}
		return $qb;
	}


}
