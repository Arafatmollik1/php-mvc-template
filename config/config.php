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
  // Default MySQL config
  'conn' => array(
    'host'      => '',
    'name'      => '',
    'username'  => '',
    'password'  => '',
  ),
  // Available controller
  'controllers' => array(
    'index' => array(
      'model'         => 'Index',
    ),
  ),

);

?>