<?php
namespace Src\Helper;
use Config\Config;
use mysqli;

class Connection
{
    /**
     * @var mysqli The MySQLi object representing the database connection.
     */
    private $database;

    /**
     * @var Connection The single instance of the class
     */
    private static $instance = null;

    /**
     * Constructor for the Connection class.
     * Made private to prevent creating multiple instances.
     */
    private function __construct()
    {
        $config = Config::getInstance()->config;
        try{
            $this->database = new mysqli($config->conn['host'], $config->conn['username'], $config->conn['password'], $config->conn['name'],9999);
        }catch(\mysqli_sql_exception $ex){
            http_response_code(500);
            include 'views/500page.php';
            exit();
        }
/*         if ($this->database->connect_error) {
            throw new \Exception("Connection failed: " . $this->database->connect_error);
        } */
    }

    /**
     * Gets the single instance of the Connection class.
     *
     * @return Connection The single instance of the Connection class
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Connection();
        }
        return self::$instance;
    }

    /**
     * Retrieves the MySQLi database connection object.
     *
     * @return mysqli The MySQLi object representing the database connection.
     */
    public function getDatabase()
    {
        return $this->database;
    }

    // Prevent cloning of the instance
    private function __clone() {}

    /**
     * Prevents unserialization of the instance.
     * 
     * @throws \Exception If someone tries to unserialize the instance.
     */
    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }
}