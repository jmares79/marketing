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
     * Fetch a row by its id
     * 
     * @param integer $id
     */
    public function fetch($id);
    
    /**
     * Insert a new row into the DB
     */
    public function insert($data);

    /**
     * Update a row by its primary id
     * 
     * @para integer $id
     */
    public function update($id);
}