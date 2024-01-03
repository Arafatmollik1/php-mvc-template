<?php

namespace Src\Helper;
use Zebra_Session;
use Src\Helper\Connection;
use Config\Config;
use mysqli;

class SessionManager
{
    /**
     * @var Zebra_Session The Zebra_Session object representing the session manager.
     */
    private $session;

    /**
     * @var SessionManager The single instance of the class
     */
    private static $instance = null;

    /**
     * Constructor for the SessionManager class.
     * Made private to prevent creating multiple instances.
     */
    private function __construct()
    {
        $config = Config::getInstance()->config;
        $database = Connection::getInstance()->getDatabase();

        $this->session = new Zebra_Session(
            $database,
            $config->session['security_code'],
            $config->session['lifetime'],
            $config->session['lock_to_user_agent'],
            $config->session['lock_to_ip'],
            900, // lock timeout
            'sessions', // session table name
            true // start session immediately
            // You can include 'read_only' parameter based on your requirement
        );
    }

    /**
     * Gets the single instance of the SessionManager class.
     *
     * @return SessionManager The single instance of the SessionManager class
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new SessionManager();
        }
        return self::$instance;
    }

    /**
     * Retrieves the Zebra_Session object.
     *
     * @return Zebra_Session The Zebra_Session object representing the session manager.
     */
    public function getSession()
    {
        return $this->session;
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
