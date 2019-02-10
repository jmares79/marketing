<?php

require_once __DIR__.'/vendor/autoload.php';

// $resources = parse_ini_file("config/config.ini");
// $stream = $resources['url'];

// 1) Create a Task to create the DB according to the parameter passed (In our example, Mysql, but it can be customized via command line if required for example)

$task = new Marketing\TaskController();
$task->execute();

var_dump($driver->fetch(2));
die;
// 2) Create a UserMapper and a User

// 3) Add data and save the user to the DDBB via the DB connection

// 4) Fetch saved data