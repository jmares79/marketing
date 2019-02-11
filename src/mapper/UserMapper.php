<?php

namespace Marketing\mapper;

use Marketing\interfaces\MapperInterface;
use Marketing\interfaces\AdapterInterface;
use Marketing\entities\User;

/**
 * Concrete User mapper, to do a bi directional connection between the User entity and the DB adapter
 */
class UserMapper implements MapperInterface
{
    /**
     * @var $adapter
     */
    protected $adapter;

    /**
     * @var $table
     */
    protected $table = 'users';

    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Finds a User
     * 
     * @param User $user
     */
    public function findBy(User $user)
    {
        return $this->adapter->fetch($user->getUsername(), $this->table);
    }

    /**
     * Saves a user into the DB
     * 
     * @param User $user
     */
    public function save(User $user)
    {
        $userData = $user->toArray();
        $rs = $this->findBy($user);

        if (!$rs) {
            $this->adapter->insert($userData, $this->table);
        } else {
            echo "UPDATING\n";
            $sql = $this->getUpdateQuery();
            $this->adapter->update($user, $this->table);
        }
    }
}
