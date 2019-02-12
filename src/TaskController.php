<?php

namespace Marketing;

use Marketing\entities\User;
use Marketing\mapper\UserMapper;
use Marketing\factories\DBFactory;
use Marketing\interfaces\MapperInterface;
use Marketing\interfaces\AdapterInterface;

/**
 * Class to execute the required example steps for the exercise.
 * It suppose to mimic a controller (In the case this was done via MVC or similar) and
 * execute the steps to show the capabilities of the software
 */
class TaskController
{
    protected $adapter;
    protected $mapper;
    protected $secondAdapter;
    protected $connection;

    public function __construct(MapperInterface $mapper, AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
        $this->mapper = $mapper;
    }

    /**
     * Method that executes the example steps
     */
    public function execute()
    {
        try {
            // $user = $this->createUser(null, null);
            $anotherUser = $this->createUser('Paul', 'mynameispaulChanged');
        } catch (\InvalidArgumentException $e) {
            echo $e->getMessage();
            die;
        }

        $userMapper = new UserMapper($this->adapter);
        $userMapper->save($anotherUser);
    }

    protected function createUser($username, $password)
    {
        return new User($username, $password);
    }
}
