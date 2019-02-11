<?php

namespace Marketing\adapters;

use Marketing\interfaces\AdapterInterface;
use PDO;

class MySql extends AbstractAdapter implements AdapterInterface
{
    protected $table;

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
    public function fetch($username, $table)
    {
        if ($username === null) {
            return $this->fetchAll($table);
        }

        $stmt = $this->connection->prepare("SELECT * FROM $table WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @inheritDoc
     */
    public function insert($data, $table)
    {
        if (empty($data)) {
            throw new InvalidArgumentException("Data parameter must be filled with proper data", 1);
        }

        $columns = implode(", ", array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?')); 
        
        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders});";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(array_values($data));
    }

    /**
     * @inheritDoc
     */
    public function update($id, $table)
    {
        // code
    }

    /**
     * Fetches all the rows in the desired table
     */
    protected function fetchAll($table)
    {
        $stmt = $this->connection->prepare('SELECT * FROM $table');
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}