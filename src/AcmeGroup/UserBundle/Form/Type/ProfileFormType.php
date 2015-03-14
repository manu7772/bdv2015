<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AcmeGroup\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\Validator\Constraint\UserPassword as OldUserPassword;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

use AcmeGroup\LaboBundle\Entity\magasinRepository;

class ProfileFormType extends AbstractType {

	private $class;
	// private $listeVilles;

	/**
	 * @param string $class The User class name
	 */
	public function __construct($class) {
		$this->class = $class;
		// $this->listeVilles = function(magasinRepository $magasin) {
		// 	return $magasin->findListeVilles();
		// };
	}

	public function buildForm(FormBuilderInterface $builder, array $options) {
		// if (class_exists('Symfony\Component\Security\Core\Validator\Constraints\UserPassword')) {
		//     $constraint = new UserPassword();
		// } else {
		//     // Symfony 2.1 support with the old constraint class
		//     $constraint = new OldUserPassword();
		// }

		$this->buildUserForm($builder, $options);
		$user = new \AcmeGroup\UserBundle\Entity\User();

		$builder
			// ->add('current_password', 'password', array(
			//     'label' => 'form.current_password',
			//     'translation_domain' => 'FOSUserBundle',
			//     'mapped' => false,
			//     'constraints' => $constraint,
			//     ))
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
			->add('commentaire', 'textarea', array(
				"required"  => false,
				"label"     => 'Complément d\'adresse :'
				))
		;

		$formAddMagasin = function(FormInterface $form, $villeChoice) {
			if($form->has('magasin')) $form->remove('magasin');
			$form->add('magasin', 'entity', array(
				"required"  => true,
				'class'     => 'AcmeGroupLaboBundle:magasin',
				'property'  => 'nommagasin',
				'multiple'  => false,
				"label"     => 'Magasin référent :',
				"query_builder" => function(magasinRepository $magasin) use ($villeChoice) {
					return $magasin->findByVille($villeChoice, true);
				}
			));
		};
		// à l'initialisation
		// $builder->addEventListener(
		// 	FormEvents::PRE_SET_DATA,
		// 	function(FormEvent $event) use ($formAddMagasin) {
		// 		$data = $event->getData();
		// 		$formAddMagasin($event->getForm(), $data->getVilleChoice());
		// 	}
		// );
		// à la mise à jour Ajax
		$builder->get('villeChoice')->addEventListener(
			FormEvents::POST_SUBMIT,
			function(FormEvent $event) use ($formAddMagasin) {
				$data = $event->getData();
				$formAddMagasin($event->getForm()->getParent(), $data);
			}
		);

	}

	public function setDefaultOptions(OptionsResolverInterface $resolver) {
		$resolver->setDefaults(array(
			'data_class' => 'AcmeGroup\UserBundle\Entity\User',
			'intention'  => 'profile',
		));
	}

	public function getName()
	{
		return 'acmegroup_user_profile';
	}

	/**
	 * Builds the embedded form representing the user.
	 *
	 * @param FormBuilderInterface $builder
	 * @param array                $options
	 */
	protected function buildUserForm(FormBuilderInterface $builder, array $options) {
		$builder
			->add('username', null, array('label' => 'form.username', 'translation_domain' => 'FOSUserBundle'))
			->add('email', 'email', array('label' => 'form.email', 'translation_domain' => 'FOSUserBundle'))
		;
	}
}
?>