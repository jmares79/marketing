<?php

namespace Marketing\factories;

use Marketing\exceptions\InvalidDriverException;

/**
 * Specifies a factory to create any DB/data adapters to be used
 */
class DBFactory
{
    public static function create($driverClass, $connection)
    {
        $class = "Marketing\adapters\\{$driverClass}";

        if (empty($connection) || $driverClass == null || $driverClass == '') {
            throw new \InvalidArgumentException();
        }

        if (!class_exists($class)) {
            throw new InvalidDriverException("The adapter driver is non existent. Please provide a valid one.", 1);
        }

        return new $class($connection);
    }
}
