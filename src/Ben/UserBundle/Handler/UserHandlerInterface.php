<?php

namespace Ben\UserBundle\Handler;


use Ben\UserBundle\Entity\User;

interface UserHandlerInterface
{
    /**
     * Get a User given the identifier
     *
     * @api
     *
     * @param mixed $id
     *
     * @return User
     */
    public function get($id);

    /**
     * Get a list of Users.
     *
     * @param int $limit  the limit of the result
     * @param int $offset starting from the offset
     *
     * @return array
     */
    public function all($limit = 5, $offset = 0);

    /**
     * Post User, creates a new User.
     *
     * @api
     *
     * @param array $parameters
     *
     * @return User
     */
    public function post(array $parameters);

    /**
     * Edit a User.
     *
     * @api
     *
     * @param User   $entity
     * @param array           $parameters
     *
     * @return User
     */
    public function put(User $entity, array $parameters);

    /**
     * Partially update a User.
     *
     * @api
     *
     * @param User   $entity
     * @param array           $parameters
     *
     * @return User
     */
    public function patch(User $entity, array $parameters);
}
