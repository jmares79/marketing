<?php

namespace Marketing\adapters;

use Marketing\interfaces\AdapterInterface;

class MySql extends AbstractAdapter implements AdapterInterface
{
    /**
     * Connects to a Mysql driver using PDO for example purposes
     */
    public function connect()
    {
        // $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);
        $this->connection = new PDO("mysql:host={$this->host};dbname={$this->database}", $this->username,$this->password);
    }

    /**
     * @inheritDoc
     */
    public function disconnect()
    {
        $this->connection = null;
    }

    /**
     * @inheritDoc
     */
    public function fetch($id)
    {
        // code
    }

    /**
     * @inheritDoc
     */
    public function insert($data)
    {
        $stmt = $this->connection->prepare("INSERT INTO USERS (username, password) VALUES (?, ?)");
        $stmt->bindParam(1, $data['username']);
        $stmt->bindParam(2, $data['password']);

        $stmt->execute();
    }

    /**
     * @inheritDoc
     */
    public function update($id)
    {
        // code
    }
}