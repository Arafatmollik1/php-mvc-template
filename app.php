<?php
// Load vendor classes
require_once __DIR__ . '/vendor/autoload.php';
// Load configuration file
$config = Config\Config::getInstance()->config;

//setup database connection
$connection = Src\Helper\Connection::getInstance();
/* $database = $connection->getDatabase(); */

//session management with Zebra
$session = Src\Helper\SessionManager::getInstance()->getSession();
// Set request data and apply action handler
$actionHandler =Src\Action\Handler::getInstance();
