<?php
/**
 * Application main config
 */
$baseUrlEnd = '/php-mvc-template';
$basePath = $_SERVER['DOCUMENT_ROOT'].$baseUrlEnd;

$baseUrl = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].$baseUrlEnd ;
$isProduction =  $_ENV['IS_PRODUCTION']; // this must be yes or no

// Set and return config
return (object) array(

  'allowed_scripts' => array(
    'index.php'
  ),
  'baseUrlEnd' =>  $baseUrlEnd,
  'basePath'   => $basePath,
  'baseUrl'    => $baseUrl,
  'isProduction' => $isProduction,
  // Default MySQL config
  'conn' => array(
    'host'      =>  $_ENV['DB_HOST'],
    'name'      =>  $_ENV['DB_NAME'],
    'username'  =>  $_ENV['DB_USERNAME'],
    'password'  =>  $_ENV['DB_PASSWORD'],
  ),

);

?>