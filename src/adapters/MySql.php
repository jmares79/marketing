<?php

namespace Marketing\adapters;

use Marketing\interfaces\AdapterInterface;

class MySql extends AbstractAdapter implements AdapterInterface
{
    /**
     * @inheritDoc
     */
    public function connect()
    {
        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);
    }

    /**
     * @inheritDoc
     */
    public function disconnect()
    {
        mysqli_close($this->connection);
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
    public function insert()
    {
        // code
    }

    /**
     * @inheritDoc
     */
    public function update($id)
    {
        // code
    }
}