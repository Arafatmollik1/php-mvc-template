<?php
namespace Helper;
use mysqli;

/**
 * Manages the database connection using MySQLi.
 *
 * This class provides a means to establish a connection to a MySQL database
 * utilizing the MySQLi extension. It attempts to connect using configuration
 * parameters and will terminate the script with an error message if the connection fails.
 *
 * Usage example:
 * $connection = new Connection();
 * $db = $connection->getDatabase();
 *
 * @property mysqli $database The MySQLi object representing the database connection.
 */
class Connection
{
    /**
     * @var mysqli The MySQLi object representing the database connection.
     */
    public $database;
    /**
     * Constructor for the Connection class.
     *
     * Establishes a connection to the MySQL database using the configuration parameters.
     * On failure, the script is terminated with an error message.
     *
     * @global object $config Contains the database configuration settings.
     * @throws \Exception If the connection to the database fails.
     */
    public function __construct()
    {
        global $config;
        $this->database = new mysqli($config->conn['host'], $config->conn['username'], $config->conn['password'], $config->conn['name']);
        if ($this->database->connect_error){
            die("Connection failed:  ".$this->database->connect_error);
        }
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

}

?>