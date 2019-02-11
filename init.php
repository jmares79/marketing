<?php

require_once __DIR__.'/vendor/autoload.php';

// $resources = parse_ini_file("config/config.ini");
// $stream = $resources['url'];

// 1) Create a Task to create the DB according to the parameter passed (In our example, Mysql, but it can be customized via command line if required for example)
// 2) Create a UserMapper and a User
// 3) Add data and save the user to the DDBB via the DB connection
// 4) Fetch saved data

// Has to be fetched from config
$connection = array(
    'host' => '127.0.0.1',
    'database' => 'marketing',
    'username' => 'root',
    'password' => ''
);

try {
    $adapter = Marketing\factories\DBFactory::create('MySql', $connection);
    $userMapper = new Marketing\mapper\UserMapper($adapter);
    
} catch (\InvalidArgumentException $e) {
    echo "Connection string must be properly filled with DB connection data\n";
} 

$task = new Marketing\TaskController($userMapper, $adapter);
$task->execute();

