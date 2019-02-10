<?php

namespace Marketing\adapters;

/**
 * Abstract class for modelling a connection adapter 
 */
abstract class AbstractAdapter
{
    protected $username;
    protected $password;
    protected $host;
    protected $database;
    protected $connection;

    public function __construct($connection)
    {
        $this->username = $connection['username'];
        $this->password = $connection['password'];
        $this->host = $connection['host'];
        $this->database = $connection['database'];
    }

    public function setHost($host)
    {
        $this->host = $host;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setDatabase($database)
    {
        $this->database = $database;
    }
} 