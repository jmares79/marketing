<?php

namespace MArketing\entities;

class User
{
    /**
     * @var string
     */
    private $username;

     /**
      * @var string
      */
    private $email;

    public function __construct($username = '', $email = '')
    {
        if ($username == '' || $email == '') {
            throw new InvalidArgumentException("Username and email cannot be empty ", 1);
        }

        $this->username = $username;
        $this->email = $email;
    }

    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function getUsername($username)
    {
        return $this->username;
    }

    public function getEmail($email)
    {
        return $this->email;
    }
}
