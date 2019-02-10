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

    public function __construct($database = 'test', $host = '127.0.0.1', $username = 'root', $password = '')
    {
        $this->username = $username;
        $this->password = $password;
        $this->host = $host;
        $this->database = $database;
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