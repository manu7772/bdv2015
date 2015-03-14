<?php
// src/AcmeGroup/UserBundle/Form/Type/RegistrationFormType.php

namespace AcmeGroup\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;
// use AcmeGroup\UserBundle\Form\UserMacType;

class RegistrationFormType extends BaseType {

    public function __construct($class) {
    	parent::__construct($class);
    }

	public function buildForm(FormBuilderInterface $builder, array $options) {
		parent::buildForm($builder, $options);
        $entity = new \AcmeGroup\UserBundle\Entity\User();
		// add your custom field
		$builder
            ->add('nom', 'text', array(
                'label'     => 'Nom :',
                'required'  => false,
                ))
            ->add('prenom', 'text', array(
                'label'     => 'Prénom :',
                'required'  => false,
                ))
            ->add('tel', 'text', array(
                'label'     => 'Téléphone :',
                'required'  => false,
                ))
            ->add('adresse', 'textarea', array(
                "required"  => false,
                "label"     => 'Adresse complète :'
                ))
            ->add('cp', 'text', array(
                "required"  => false,
                "label"     => 'Code Postal :'
                ))
            ->add('ville', 'text', array(
                "required"  => false,
                "label"     => 'Ville :'
                ))
        ;
	}

	public function getName() {
		return 'acmegroup_user_registration';
	}

}

?>