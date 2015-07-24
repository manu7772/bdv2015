<?php

namespace AcmeGroup\LaboBundle\Entity;

use AcmeGroup\LaboBundle\Entity\tag;
use \DateTime;

/**
 * Éléments pour entité de base avec attributs
 */
interface baseTagsInterface {

	public function addTag(tag $tag);
	public function removeTag(tag $tag);
	public function getTags();

}