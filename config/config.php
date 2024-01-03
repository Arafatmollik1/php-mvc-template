<?php
/**
 * Application main config
 */
namespace Config;
use Dotenv\Dotenv;
class Config
{
  private static $instance = null;
  public $config;

  private function __construct()
  {
    $baseUrlEnd = '/php-mvc-template';
    //loading .env files access them via $_ENV[] with all capital
    $_env = Dotenv::createImmutable(__DIR__ . '/../');
    $_env->load();
    $basePath = $_SERVER['DOCUMENT_ROOT'].$baseUrlEnd;
    
    $isProduction =  $_ENV['IS_PRODUCTION']; // this must be yes or no
    $isMaintenanceEnabled = isset($_ENV['MAINTENANCE_ENABLED']) ?  ($_ENV['MAINTENANCE_ENABLED']  == 'yes' ? true : false) : false;

    $configArray = [
      'allowed_scripts' => array(
        'index.php'
      ),
      'baseUrlEnd' =>  $baseUrlEnd,
      'basePath'   => $basePath,
      'isProduction' => $isProduction,
      // Default MySQL config
      'conn' => array(
        'host'      =>  $_ENV['DB_HOST'],
        'name'      =>  $_ENV['DB_NAME'],
        'username'  =>  $_ENV['DB_USERNAME'],
        'password'  =>  $_ENV['DB_PASSWORD'],
      ),
      'maintenance' =>  array(
        'enabled'    =>  $isMaintenanceEnabled,
      ),
      'session' => array(
        'security_code'       => $_ENV['SESSION_PASSWORD'],
        'lifetime'            => 60 * 24 * 60 * 60,
        'lock_to_user_agent'  => true,
        'lock_to_ip'          => false,
      ),
    
      // REST API config
      // Set common properties and define available endpoints
      'api_config' => array(
        'enabled'               => true,
        'enable_authentication' => false,
        'authentication' => array(
          'user'      => $_ENV['LOCAL_API_USER'],
          'password'  => $_ENV['LOCAL_API_PASSWORD']
        ),
        'endpoints' => array(
          'example' => array( //this is the name of controller, all small letter and no hyphens
            'uri' => '/api/v1/example',//uri can have hyphens and letter case font matter
          ),
          'exampletwo' => array(
            'uri' => '/api/v2/example',
          ),
        )
    ),
    ];
    // Convert array to object
    $this->config = (object) $configArray;
  }

  public static function getInstance()
  {
    if (self::$instance === null) {
      self::$instance = new Config();
    }
    return self::$instance;
  }
  // Prevent cloning of the instance
  public function __clone()
  {
    throw new \Exception("Cloning a Singleton is not allowed");
  }

  // Prevent unserialization of the instance
  public function __wakeup()
  {
    throw new \Exception("Unserializing a Singleton is not allowed");
  }

  public function get($key)
  {
    return isset($this->config[$key]) ? $this->config[$key] : null;
  }
}