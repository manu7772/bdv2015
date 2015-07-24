<?php

namespace AcmeGroup\LaboBundle\Entity;

use AcmeGroup\LaboBundle\Entity\baseLaboRepository;
use Doctrine\ORM\QueryBuilder;
use \Exception;
use \DateTime;

/**
 * emailRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class emailRepository extends baseLaboRepository {

	/**
	 * Renvoie la(les) valeur(s) par défaut
	 * $onlyOneObject : si true, renvoie un seul objet en résultat, ou null - false, renvoie un tableau (vide si aucun)
	 * @param mixed $defaults - valeur(s) par défaut du $champ
	 * @param boolean $onlyOneObject
	 * @return mixed
	 */
	public function defaultVal($defaults = null, $onlyOneObject = false, $champ = 'nom') {
		// !!! Ne doit rien renvoyer, c'est juste une liste d'éléments !!!
		return array();
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
