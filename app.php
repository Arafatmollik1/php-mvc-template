<?php
// Load vendor classes
require_once __DIR__ . '/vendor/autoload.php';
//loading .env files access them via $_ENV[] with all capital
$_env = Dotenv\Dotenv::createImmutable(__DIR__);
$_env->load();
// Load config
$config = include('config/config.php');
// Load src classes
require_once 'includes/autoload.php';

// Initiate common helper
global $commonHelper;
$commonHelper = new Helper\Common();
//setup database connection
$connection = Helper\Connection::getInstance();
global $database;
$database = $connection->getDatabase();
require_once 'includes/session.php';
// Set request data and apply action handler
require_once 'includes/action.php';
