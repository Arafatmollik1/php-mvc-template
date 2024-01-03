<?php

namespace Src\Utility;
use Config\Config;


class LocalApi {

    // master switch of API
    protected $enabled = false;

    // default script
    protected $scriptName = 'apirouter.php';

    // available endpoints (defined in config)
    protected $endpoints = array();

    // general api config properties
    protected $apiConfig = array();
    protected $statusCode = null;

    // request related data
    protected $uri          = null;
    protected $path         = null;
    protected $controller   = null;
    protected $action       = null;
    protected $actionMethod = null;
    protected $query        = array();
    protected $post         = array();
    protected $json         = '';

    // API request URL
    public $apiPath = null;
    public $apiUrl  = null;
    public $config;

    /**
     * Initiate API helper and set common properties
     */
    public function __construct() {
        $this->config = Config::getInstance()->config;
        // Get config properties and set common params
        $this->setConfig();

        // Validate API status and request
        $scriptName = basename($_SERVER["SCRIPT_NAME"]);
        if (
            $scriptName !== $this->scriptName
            || !file_exists($_SERVER["SCRIPT_FILENAME"])
            || false === $this->enabled
        ) {
            $this->terminate(500);
            exit;
        }

        // Current request URI
        $this->setUri();

        // Current path
        $this->setPath();

        // Set query string
        $this->setQueryString();

        // Set post data
        $this->setPostData();

        // Set json data
        $this->setJson();

        // Set request controller
        $this->setController();

        // Current script action
        $this->setAction();

        // Set API router path
        $this->setApiPath();

        return $this;
    }

    /**
     * Get API settings
     * @return null
     */
    protected function setConfig() {
        if (isset($this->config->api_config)) {
            $this->apiConfig = $this->config->api_config;
            $this->enabled = $this->config->api_config['enabled'];
            if (isset($this->config->api_config['endpoints'])) {
                $this->endpoints = $this->config->api_config['endpoints'];
            }
        }
    }



    /**
       * Set path based on current URI
       * @return null
       */
    protected function setPath() {
        if (isset($_SERVER["REQUEST_URI"]) && !empty($_SERVER["REQUEST_URI"])) {
            $paths = preg_split('@/@', $this->uri, -1, PREG_SPLIT_NO_EMPTY);
            if (sizeof($paths) == 0) {
                $paths[] = 'index';
            }
            $this->path = $paths;
        }
    }

    /**
     * Set URI
     * @return null
     */
    protected function setUri() {
    
        if (isset($_SERVER["REQUEST_URI"]) && !empty($_SERVER["REQUEST_URI"])) {
            // Remove query string from the URI
            $uri = strtok($_SERVER["REQUEST_URI"], '?');
    
            // Remove base URL from the URI
            if (!empty($this->config->baseUrlEnd)) {
                $uri = substr($uri, strlen($this->config->baseUrlEnd)); 
            }
    
            $this->uri = $uri;
        } else {
            $this->uri = $_SERVER["SCRIPT_NAME"];
        }
    }

    /**
       * Store query string data
       * @return null
       */
    protected function setQueryString() {

        if (isset($_GET) && is_array($_GET)) {
            $this->query = $_GET;
        }
    }

    /**
       * Get post data
       * @return null
       */
    protected function setPostData() {
        if (isset($_POST) && is_array($_POST)) {
            $this->post = $_POST;
        }
    }

    /**
       * Get requst json
       * @return null
       */
    protected function setJson() {
        $json = file_get_contents('php://input');
        $this->json = json_decode($json, true);
    }

    /**
     * Set controller 
     * @return null
     */
    protected function setController() {
    
        // Initialize the best match length to a very small number
        $bestMatchLength = 0;
        $this->controller = null;
    
        // Iterate through the endpoints
        foreach ($this->endpoints as $key => $item) {
            // Check if the endpoint's URI is a substring of $this->uri
            if (strpos($this->uri, $item['uri']) === 0) {
                // Calculate the length of the match
                $matchLength = strlen($item['uri']);
    
                // Check if this is the best match so far
                if ($matchLength > $bestMatchLength) {
                    $bestMatchLength = $matchLength;
                    $this->controller = $key;
                }
            }
        }
    }
    
    

    /**
     * Get API request base path
     */
    protected function setApiPath() {
        if (is_array($this->path) && sizeof($this->path) > 1) {
            $pathArray = array_splice($this->path, 0, count($this->path) - 2);
            $this->apiPath = implode("/", array_map('ucfirst', $pathArray));
        }
    }

    /**
       * Set action (controller method)
       * @return null
       */
      protected function setAction() {
        if (is_array($this->path) && sizeof($this->path) > 1) {
            // Extract the last element from $this->path and remove hyphens
            $actionWithHyphens = $this->path[sizeof($this->path) - 1];
            $actionWithoutHyphens = str_replace('-', '', $actionWithHyphens);
    
            // Convert to lowercase
            $this->action = strtolower($actionWithoutHyphens);
            $this->actionMethod = $this->action . 'Action';
        }
    }

    /**
     * Validate authentication
     * @var boolean
     */
    protected function isUserPassValid($str) {
        $user_pass = $this->config->api_config['authentication']['user'].':'.$this->config->api_config['authentication']['password'];
        if ($user_pass === $str) {
            return true;
        }
        return false;
    }

    /**
     * Verify that headers are valid
     * @return boolean [description]
     */
    protected function isHeadersValid() {

        if (!$this->apiConfig['enable_authentication']) {
            return true;
        }

        // Get request headers
        $headers = getallheaders();
        if (isset($headers['Authorization']) && !empty($headers['Authorization'])) {
            preg_match('/^Basic\s+(.*)$/i', $headers['Authorization'], $user_pass);
            $str = base64_decode($user_pass[1]);
            if ($this->isUserPassValid($str)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Validate endpoint and send request
     * @return void
     */
    public function processApiRequest() {

        // Verify headers
        //This checks if credentials are matching
        if (!$this->isHeadersValid()) {
            $this->terminate(403);
            exit;
        }

        // Locate API request URI from available endpoints
        $endpoints = $this->endpoints;
        $lowercaseUri = strtolower($this->uri);
        if (is_array($endpoints) && sizeof($endpoints) > 0) {
            foreach ($endpoints as $key => $item) {
                if (strpos($lowercaseUri, strtolower($item['uri'])) !== false) {
                    $this->apiUrl = $item['uri'];
                    break;
                }
            }
        }

        if (!empty($this->apiUrl)) {
            $this->makeApiRequest();
        } else {
            $this->terminate(400);
        }
    }

    /**
     * Execute API request to endpoint
     * @return void
     */
    protected function makeApiRequest() {
        $response = false;
        $class = $this->getRequestClassName();
        $actionMethod = $this->actionMethod;

        // Init controller class
        $classModel = new $class();
        if (method_exists($classModel, $actionMethod)) {
            try{
                $response = $classModel->$actionMethod($this->query, $this->post, $this->json);
            }
            catch(\Exception $e){
                error_log($e->getMessage());
                $this->terminate(500);
            }
        }

        if (false === $response) {
            $this->error(400);
        } else {
            $this->response(200, $response);
        }
    }

    protected function getRequestClassName() {
        $path = "\\" . str_replace("/", "\\", $this->apiPath) . "\\";
        $class = "Src\\Controllers" . $path . $this->controller;
        return $class;
    }

    public function response($status, $data) {
        $this->statusCode = $status;
        http_response_code($status);
        $message = array(
            "status"  => $status,
            "message" => "Success",
            "data"    => $data
        );
        echo json_encode(['result' => $message]);
    }

    /**
     * Terminate request and output error
     * @param  int $status
     * @return void
     */
    public function terminate($status) {
        $this->statusCode = $status;
        http_response_code($status);
        $message = array(
            "status"  => $status,
            "message" => "An error occurred while accessing the endpoint.",
            "data"    => ""
        );
        echo json_encode(['result' => $message]);
    }

    /**
     * Stop processing and return error
     * @param  int $status
     * @return void
     */
    public function error($status) {
        $this->statusCode = $status;
        http_response_code($status);
        $message = array(
            "status"  => $status,
            "message" => "An error occurred while processing the request.",
            "data"    => ""
        );
        echo json_encode(['result' => $message]);
    }

   
}


// checkout config.php
/* 
This configuration must be in place

'api_config' => array(
    'enabled'               => true,
    'enable_authentication' => false,
    'authentication' => array(
      'user'      => $_ENV['LOCAL_API_USER'],
      'password'  => $_ENV['LOCAL_API_PASSWORD']
    ),
    'endpoints' => array(
      'example' => array(
        'uri' => '/api/v1/example',  <-- here is the endpoint you are going to use
      ),
    )
  ),
); 

Now create a file under src/Controllers/Api/V1/<lastpoint>.php
now follow src/Controllers/Api/V1/Example.php
*/