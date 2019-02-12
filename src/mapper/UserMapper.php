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
     * 
     * @return array Array with the user data
     */
    public function findBy(User $user)
    {
        return $this->adapter->fetch(array('username' => $user->getUsername()), $this->table);
    }

    /**
     * Saves a user into the DB
     * 
     * @param User $user
     * 
     * @return bool On success or not
     */
    public function save(User $user)
    {
        $userData = $user->toArray();
        $recordSet = $this->findBy($user);

        try {
            if (!$recordSet) {
                $res = $this->adapter->insert($userData, $this->table);
            } else {
                $fieldsToUpdate = array_diff($userData, $recordSet);

                if (empty($fieldsToUpdate)) { return true; }

                $res = $this->adapter->update($fieldsToUpdate, $recordSet['id'], $this->table);
            }
        } catch (\InvalidArgumentException $e) {
            var_dump($e->getMessage());
            return false;
        }

        return $res;
    }
}
