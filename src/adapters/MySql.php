<?php

namespace Marketing\adapters;

use Marketing\interfaces\AdapterInterface;
use PDO;

/**
 * Adapter to handle MySql connections
 */ 
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
    public function fetch($whereClause, $table)
    {
        if (empty($whereClause)) {
            return $this->fetchAll($table);
        }

        $field = array_keys($whereClause)[0];
        $value = $whereClause[$field];

        $stmt = $this->connection->prepare("SELECT * FROM $table WHERE $field = :$field");
        $stmt->bindParam(":$field", $value);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @inheritDoc
     */
    public function insert($data, $table)
    {
        if (empty($data)) {
            throw new \InvalidArgumentException("Data parameter must be filled with proper data", 1);
        }

        $columns = implode(", ", array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?')); 
        
        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders});";
        $stmt = $this->connection->prepare($sql);
        
        return $stmt->execute(array_values($data));
    }

    /**
     * @inheritDoc
     */
    public function update($data, $id, $table)
    {
        if (empty($data) || $id == null) {
            throw new \InvalidArgumentException("Data and id must be filled with proper data", 1);
        }

        $setQuery = '';

        foreach ($data as $key => $value) {
            $setQuery .= "`$key` = '$value' ,";
        }

        $setQuery = rtrim($setQuery, ",");

        $sql = "UPDATE {$table} SET $setQuery WHERE id = ?;";
        $stmt = $this->connection->prepare($sql);

        return $stmt->execute(array($id));
    }

    /**
     * Fetches all the rows in the desired table
     * 
     * @param string $table
     */
    protected function fetchAll($table)
    {
        $stmt = $this->connection->prepare("SELECT * FROM $table");
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
