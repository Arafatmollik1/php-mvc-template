<?php
/**
 * Application main config
 */

$basePath = $_SERVER['DOCUMENT_ROOT'];

$baseUrl = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'];

// Set and return config
return (object) array(

  'allowed_scripts' => array(
    'index.php'
  ),
  'baseUrlEnd' =>  '/php-mvc-template',
  // Default MySQL config
  'conn' => array(
    'host'      => 'localhost',
    'name'      => 'just_testing',
    'username'  => 'root',
    'password'  => 'root',
  ),

);

?>