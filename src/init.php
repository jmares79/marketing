<?php

require_once __DIR__.'/vendor/autoload.php';

$resources = parse_ini_file("config/config.ini");
$stream = $resources['url'];

// 1) Create a DB according to the parameter passed (In our example, Mysql, but it can be customized via command line)

// 2) Create a UserMapper and a User

// 3) Add data and save the user to the DDBB via the DB connection

// 4) Fetch saved data