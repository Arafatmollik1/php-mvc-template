<?php
// Load config
$config = include('config/config.php');
// Load src classes
require_once 'includes/autoload.php';

// Initiate common helper
global $common;
$common = new Helper\Common();

require_once 'includes/session.php';
// Set request data and apply action handler
require_once 'includes/action.php';

global $currentAction;
$currentAction = $actionHandler->getAction();

//setup database connection
$connection = new Helper\Connection();
global $database;
$database = $connection->database;