<?php

namespace AcmeGroup\LaboBundle\Entity;

use labo\Bundle\TestmanuBundle\Entity\typeRepository as typeBaseRepo;

/**
 * statutRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class statutRepository extends typeBaseRepo {

	public function defaultVal($defaults = null) {
		if($defaults === null) $defaults = array("Actif");
		return parent::defaultVal($defaults);
	}

}
