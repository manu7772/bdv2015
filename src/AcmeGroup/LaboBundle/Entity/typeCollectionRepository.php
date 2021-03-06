<?php

namespace AcmeGroup\LaboBundle\Entity;

use AcmeGroup\LaboBundle\Entity\baseLaboRepository;
use Doctrine\ORM\QueryBuilder;
use \Exception;
use \DateTime;

/**
 * typeCollectionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class typeCollectionRepository extends baseLaboRepository {

	const DEFAULT_TYPE_COLLECTION 	= "image";

	/**
	 * Renvoie la(les) valeur(s) par défaut
	 * $onlyOneObject : si true, renvoie un seul objet en résultat, ou null - false, renvoie un tableau (vide si aucun)
	 * @param mixed $defaults - valeur(s) par défaut du $champ
	 * @param boolean $onlyOneObject
	 * @return mixed
	 */
	public function defaultVal($defaults = null, $onlyOneObject = false, $champ = 'nom') {
		// valeurs spécifiques
		if($defaults === null) $defaults = array(self::DEFAULT_TYPE_COLLECTION);
		// $champ = 'slug';
		return parent::defaultVal($defaults, $onlyOneObject, $champ);
	}

	/**
	 * Renvoie la(les) valeur(s) selon le(s) ROLE(S) --> ATTENTION : retourne un queryBuilder
	 * @param mixed $roles - ROLES à prendre en compte
	 * @param string $champ - 'nom' par défaut
	 * @return queryBuilder
	 */
	public function defaultRoleClosure($roles = null, $champ = 'nom') {
		// valeurs spécifiques
		// $champ = 'slug';
		return parent::defaultRoleClosure($roles, $champ);
	}




}
