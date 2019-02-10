<?php

namespace Marketing;

use Marketing\entities\User;
use Marketing\mapper\UserMapper;
use Marketing\factories\DBFactory;

/**
 * Class to execute the required example steps for the exercise.
 * It suppose to mimic a controller (In the case this was done via MVC or similar) and
 * execute the steps to show the capabilities of the software
 */
class TaskController
{
    protected $adapter;
    protected $secondAdapter;
    protected $connection;

    public function __construct()
    {
        $this->connection = array(
            'host' => '127.0.0.1',
            'database' => 'marketing',
            'username' => 'root',
            'password' => ''
        );
    }

    /**
     * Method that executes the example steps
     */
    public function execute()
    {
        $this->adapter = DBFactory::create('MySql', $this->connection);
        // $this->secondAdapter =DBFactory::create('MagicSql', $this->connection);

        $user = $this->createUser('John', 'mynameisjohn');
        $anotherUser = $this->createUser('Paul', 'mynameispaul');

        $userMapper = new UserMapper($this->adapter);

        $userMapper->save($user);
    }

    protected function createUser($username, $password)
    {
        return new User($username, $password);
    }
}