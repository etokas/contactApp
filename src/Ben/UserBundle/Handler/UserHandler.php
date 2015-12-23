<?php

namespace Ben\UserBundle\Handler;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormFactoryInterface;
use Ben\UserBundle\Entity\User;
use Ben\UserBundle\Form\UserType;
use Ben\UserBundle\Exception\InvalidFormException;

class UserHandler implements UserHandlerInterface
{
    private $om;
    private $entityClass;
    private $repository;
    private $formFactory;

    public function __construct(ObjectManager $om, $entityClass, FormFactoryInterface $formFactory)
    {
        $this->om = $om;
        $this->entityClass = $entityClass;
        $this->repository = $this->om->getRepository($this->entityClass);
        $this->formFactory = $formFactory;
    }

    /**
     * Get a User.
     *
     * @param mixed $id
     *
     * @return User
     */
    public function get($id)
    {
        return $this->repository->find($id);
    }

    /**
     * Get a list of Users.
     *
     * @param int $limit  the limit of the result
     * @param int $offset starting from the offset
     *
     * @return array
     */
    public function all($limit = 5, $offset = 0)
    {
        return $this->repository->findBy(array(), null, $limit, $offset);
    }

    /**
     * Create a new User.
     *
     * @param array $parameters
     *
     * @return User
     */
    public function post(array $parameters)
    {
        $User = $this->createUser();

        return $this->processForm($User, $parameters, 'POST');
    }

    /**
     * Edit a User.
     *
     * @param User $User
     * @param array         $parameters
     *
     * @return User
     */
    public function put(User $User, array $parameters)
    {
        return $this->processForm($User, $parameters, 'PUT');
    }

    /**
     * Partially update a User.
     *
     * @param User $User
     * @param array         $parameters
     *
     * @return User
     */
    public function patch(User $User, array $parameters)
    {
        return $this->processForm($User, $parameters, 'PATCH');
    }

    /**
     * Processes the form.
     *
     * @param User $User
     * @param array         $parameters
     * @param String        $method
     *
     * @return User
     *
     * @throws \Ben\UserBundle\Exception\InvalidFormException
     */
    private function processForm(User $User, array $parameters, $method = "PUT")
    {
        $form = $this->formFactory->create(new UserType(), $User, array('method' => $method));
        $form->submit($parameters, 'PATCH' !== $method);
        if ($form->isValid()) {

            $User = $form->getData();
            $this->om->persist($User);
            $this->om->flush($User);

            return $User;
        }

        throw new InvalidFormException('Invalid submitted data', $form);
    }

    private function createUser()
    {
        return new $this->entityClass();
    }

}
