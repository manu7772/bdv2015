<?php

namespace AcmeGroup\LaboBundle\Entity;

use labo\Bundle\TestmanuBundle\Entity\typeRepository;

/**
 * tvaRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class tvaRepository extends typeRepository {

	public function defaultVal($defaults = null) {
		if($defaults === null) $defaults = array("Normal");
		return parent::defaultVal($defaults);
	}

}
