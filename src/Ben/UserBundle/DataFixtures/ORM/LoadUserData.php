<?php
namespace Ben\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Ben\UserBundle\Entity\User;

class LoadUserData implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $admin = $this->getUser('admin', 'admin', 'admin@gmail.com', '0604543344');
        $manager->persist($admin);
        for ($i=0; $i < 5; $i++) {
            $user = $this->getUser("user$i", "user", "user$i@gmail.com", "0604543344");
            $manager->persist($user);
        }

        $manager->flush();
    }

    public function getUser($username, $password, $email, $phoneNumber){
        $user = new User();
        $user->setFirstName($username);
        $user->setLastName($username);
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setEnabled(true);
        $user->setPhoneNumber($phoneNumber);
        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($user, $password);
        $user->setPassword($password);

        return $user;
    }
}
