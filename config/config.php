<?php
/**
 * Application main config
 */
$baseUrlEnd = '/php-mvc-template';
$basePath = $_SERVER['DOCUMENT_ROOT'].$baseUrlEnd;

$baseUrl = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].$baseUrlEnd ;

// Set and return config
return (object) array(

  'allowed_scripts' => array(
    'index.php'
  ),
  'baseUrlEnd' =>  $baseUrlEnd,
  'basePath'   => $basePath,
  'baseUrl'    => $baseUrl,
  // Default MySQL config
  'conn' => array(
    'host'      => 'localhost',
    'name'      => 'just_testing',
    'username'  => 'root',
    'password'  => 'root',
  ),

);

?>