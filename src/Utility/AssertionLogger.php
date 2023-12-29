<?php
namespace Utility;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Webmozart\Assert\Assert;
use Webmozart\Assert\InvalidArgumentException;

class AssertionLogger
{
    private $logger;
    const LOGGER_PATH = '/logs';

    public function __construct($logChannel = 'default')
    {
        global $config;
        $this->logger = new Logger($logChannel);
        // Define a log path relative to the project root
        $logDirectory = $config->basePath . self::LOGGER_PATH;

        // Check if the directory exists, if not, create it
        if (!file_exists($logDirectory)) {
            mkdir($logDirectory, 0777, true);
        }

        // Define the full path for the log file
        $logPath = $logDirectory . '/app.log';
        $this->logger->pushHandler(new StreamHandler($logPath, Logger::WARNING));
    }

    public function assert(callable $assertion, $message)
    {
        try {
            $assertion();
        } catch (InvalidArgumentException $e) {
            $this->logger->warning($message, ['exception' => $e]);
            // Optionally re-throw the exception if you want it to be handled further up the chain
            // throw $e;
        }
    }
}

// Usage
/*
$assertionLogger = new AssertionLogger();

 $var = 'example';
$assertionLogger->assert(function() use ($var) {
    Assert::stringNotEmpty($var);
}, 'Variable must be a non-empty string'); 
*/
