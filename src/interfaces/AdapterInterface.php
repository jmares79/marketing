<?php

namespace Marketing\interfaces;

interface AdapterInterface
{
    /**
     * Creates a connects to a DB
     */
    public function connect();
    
    /**
     * Disconnect the adapter from the DB
     */
    public function disconnect();

    /**
     * Fetch a row by its username
     * 
     * @param array $whereClause Contains the generic where clause in a way 'field' => value
     * @param string $table
     */
    public function fetch($whereClause, $table);
    
    /**
     * Insert a new row into the DB
     * 
     * @param array $data
     * @param string $table
     */
    public function insert($data, $table);

    /**
     * Update a row by its primary id
     * 
     * @param array $data
     * @param integer $id
     * @param string $table
     */
    public function update($data, $id, $table);
}