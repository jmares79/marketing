<?php

namespace Marketing\adapters;

use Marketing\interfaces\AdapterInterface;
use PDO;

class MySql extends AbstractAdapter implements AdapterInterface
{
    public function __construct($connection)
    {
        parent::__construct($connection);
        $this->connect();
    }

    /**
     * Connects to a Mysql driver using PDO for example purposes
     */
    public function connect()
    {
        $this->connection = new PDO("mysql:host={$this->host};dbname={$this->database}", $this->username, $this->password);
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
        if ($id === null) {
            return $this->fetchAll();
        }

        $stmt = $this->connection->prepare('SELECT * FROM users WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
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

    protected function fetchAll()
    {
        $stmt = $this->connection->prepare('SELECT * FROM users');
        $rows = $stmt->execute();

        var_dump($rows);
        die;
    }
}