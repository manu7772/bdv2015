<?php

namespace AcmeGroup\LaboBundle\Entity;

use AcmeGroup\LaboBundle\Entity\baseLaboRepository;
use Doctrine\ORM\QueryBuilder;
use \Exception;
use \DateTime;

/**
 * valeurRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class valeurRepository extends baseLaboRepository {

	/**
	 * Renvoie la(les) valeur(s) par défaut
	 * $onlyOneObject : si true, renvoie un seul objet en résultat, ou null - false, renvoie un tableau (vide si aucun)
	 * @param mixed $defaults - valeur(s) par défaut du $champ
	 * @param boolean $onlyOneObject
	 * @return mixed
	 */
	public function defaultVal($defaults = null, $onlyOneObject = false, $champ = 'nom') {
		// valeurs spécifiques
		// $champ = 'slug';
		return array();
	}




}
