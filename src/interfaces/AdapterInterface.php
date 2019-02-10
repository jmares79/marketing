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
     * @param string $username
     * @param string $table
     */
    public function fetch($username, $table);
    
    /**
     * Insert a new row into the DB
     * 
     * @param mixed $data
     * @param string $table
     */
    public function insert($data, $table);

    /**
     * Update a row by its primary id
     * 
     * @param integer $id
     * @param string $table
     */
    public function update($id, $table);
}