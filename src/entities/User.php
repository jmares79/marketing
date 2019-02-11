<?php

namespace Marketing\entities;

class User
{
    /**
     * @var string
     */
    private $username;

     /**
      * @var string
      */
    private $password;

    public function __construct($username = '', $password = '')
    {
        if ($username == '' || $password == '') {
            throw new InvalidArgumentException("Username and password cannot be empty ", 1);
        }

        $this->username = $username;
        $this->password = $password;
    }

    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function toArray()
    {
        return get_object_vars($this);
    }
}
