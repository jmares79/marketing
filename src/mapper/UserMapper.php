<?php

namespace Marketing\mapper;

use Marketing\interfaces\MapperInterface;

/**
 * Concrete User mapper, to do a bi directional connection between the User entity and the DB adapter
 */
class UserMapper implements MapperInterface
{
    /**
     * @var StorageAdapter
     */
    private $adapter;

    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Finds a User by its id
     * 
     * @param integer $id
     */
    public function findById($id)
    {
        return $this->adapter->fetch($id);
    }

    /**
     * Saves a user into the DB
     * 
     * @param User $user
     */
    public function save(User $user)
    {
        $rs = $this->adapter->fetch($id);

        if ($rs === null) {
            $this->adapter->insert($user);
        } else {
            $this->adapter->update($user);
        }
    }
}
