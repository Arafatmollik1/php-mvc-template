<?php
namespace Helper;

/**
 * intiate database
 */
class Connection
{

    public $database;
    public function __construct()
    {
        global $config;
        $this->database = new \mysqli($config->conn['host'], $config->conn['username'], $config->conn['password'], $config->conn['name']);
        if ($this->database->connect_error){
            die("Connection failed:  ".$this->database->connect_error);
        }
    }

}

?>