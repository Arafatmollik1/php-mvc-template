<?php
namespace Src\Utility;
use Config\Config;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\ErrorLogHandler;

class DebugLogger
{
    private $logger;
    const LOGGER_PATH = '/logs';
    public $config;

    public function __construct($logChannel = 'default')
    {
        $this->config = Config::getInstance()->config;
        $this->logger = new Logger($logChannel);
        // Define a log path relative to the project root
        $logDirectory = $this->config->basePath . self::LOGGER_PATH;

        // Check if the directory exists, if not, create it
        if (!file_exists($logDirectory)) {
            mkdir($logDirectory, 0777, true);
        }

        // Define the full path for the log file
        $logPath = $logDirectory . '/app.log';

        // Create a StreamHandler to log warnings to a file
        $fileHandler = new StreamHandler($logPath, Logger::WARNING);
        $this->logger->pushHandler($fileHandler);

        // Create an ErrorLogHandler to log PHP errors to the PHP error log
        $errorLogHandler = new ErrorLogHandler();
        $this->logger->pushHandler($errorLogHandler);
    }

    public function logWarning($message)
    {
        $this->logger->warning($message);
    }
}

// Usage
/*
$myLogger = new DebugLogger();

$myLogger->logWarning('This is a warning message');

*/
