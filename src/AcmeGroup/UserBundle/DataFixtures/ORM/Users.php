<?php

namespace AcmeGroup\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
// container
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
// Entité
use AcmeGroup\UserBundle\Entity\User;

class Users extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {
	private $ord			= 9;			// Ordre de chargement fixtures
	private $entity			= "AcmeGroup\\UserBundle\\Entity\\User";		// nom de l'entité
	private $container;
	private $manager;

	public function getOrder() { return $this->ord; } // l'ordre dans lequel les fichiers sont chargés

	/**
	 * {@inheritDoc}
	 */
	public function setContainer(ContainerInterface $container = null) {
		$this->container = $container;
	}

    public function load(ObjectManager $manager) {
        // Remise à zéro de l'auto-incrément
        $this->manager = $manager;
        $connection = $this->manager->getConnection();
        $connection->exec("ALTER TABLE User AUTO_INCREMENT = 1;");

		$person = array(
			array(
				'setUsername'	=> "manu7772",
				'setEnabled'	=> true,
				'setRoles'		=> array("ROLE_USER"),
				'getSalt'		=> md5(uniqid()),
				'setPassword'	=> "azetyu123",
				'setMembre'		=> "email:manu7772@gmail.com"
				),
			array(
				'setUsername'	=> "admin7772",
				'setEnabled'	=> true,
				'setRoles'		=> array("ROLE_EDITOR"),
				'getSalt'		=> md5(uniqid()),
				'setPassword'	=> "admin",
				'setMembre'		=> "email:manu7772@free.com"
				),
			array(
				'setUsername'	=> "sadmin",
				'setEnabled'	=> true,
				'setRoles'		=> array("ROLE_SUPER_ADMIN"),
				'getSalt'		=> md5(uniqid()),
				'setPassword'	=> "sadmin",
				'setMembre'		=> "email:emmanuel@aequation-webdesign.fr"
				),
			array(
				'setUsername'	=> "aymeric",
				'setEnabled'	=> true,
				'setRoles'		=> array("ROLE_ADMIN"),
				'getSalt'		=> md5(uniqid()),
				'setPassword'	=> "marion2015",
				'setMembre'		=> "email:laboucherieduveyron@orange.fr"
				),
		);

		foreach($person as $i => $pers) {
			$user = new User;
			foreach($pers as $att => $val) {
				switch ($att) {
					case 'setPassword':
						$encoder = $this->container->get('security.encoder_factory')->getEncoder($user);
						$user->setPassword($encoder->encodePassword($val, $user->getSalt()));
						break;
					case 'setMembre':
						$membre = explode(":", $val, 2);
						$find = "findBy".ucfirst($membre[0]);
						$userMembre = $this->container->get('acmeGroup.membre')->getRepo()->$find($membre[1]);
						// $userMembre = $this->container->getDoctrine()->getManager()->getRepository('AcmeGroupBundle:membre')->$find($membre[1]);
						if(count($userMembre) > 0) echo("Membre trouvé (".$membre[1].") : ".count($userMembre)."\n");
							else echo("Membre non trouvé (".$membre[1].")\n");
						if(count($userMembre) > 0) {
							$user->$att($userMembre[0]);
							if($membre[0] === "email") {
								$user->setEmail($membre[1]);
							}
							// $userMembre[0]->setUser($user);
							// $manager->persist($userMembre[0]);
						}
						break;
					default:
						$user->$att($val);
						break;
				}
			}
			$manager->persist($user);
			$manager->flush();
			unset($user);
			$user = null;
		}

	}

}
