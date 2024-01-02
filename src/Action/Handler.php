<?php

namespace Action;

/**
 * Request validator and action handler
 */
class Handler
{
	// Current page action
	public $action = 'index';

	// Current controller
	public $controller = 'index'; // default index

	protected $pathStructure = "";

	public function __construct() {
		$this->setPathStructure();
		$this->getRoute($this->pathStructure);
	}
	protected function setPathStructure(){
		global $config;
		$this->pathStructure = $config->baseUrlEnd;
	}
	public function getRoute($path) {
		$uri = $_SERVER['REQUEST_URI'];
	
		// Check if there is a query string, and split the URI if needed
		if (strpos($uri, '?') !== false) {
			list($pathUri, $queryString) = explode('?', $uri, 2);
			// Parse the query string into an associative array
			parse_str($queryString, $queryParams);
		} else {
			$pathUri = $uri;
			$queryParams = [];
		}
	
		$routePath = trim(str_replace($path, '', $pathUri), '/');
	
		$segments = explode('/', $routePath);
	
		$this->controller = (!isset($segments[0]) || empty($segments[0])) ? 'index' : $segments[0];
		$this->action = $segments[1] ?? 'index';
	}


	/**
	 * Retrieve current controller
	 * @return string
	 */
	public function getController() {
		return $this->controller;
	}

	/**
	 * Retrieve current action
	 * @return string
	 */
	public function getAction() {
		return $this->action;
	}	

	/**
	 * Get controller model class
	 * @return string
	 */
	public function getControllerModel() {
		// Error handling if the controller class does not exist
		$className = "Controllers\\" . ucwords($this->controller);
		if (!class_exists($className)) {
			return null;
		}

		$classModel = new $className;
		return $classModel;
	}

	/**
	 * Get controller action model
	 * @return string
	 */
	public function getControllerAction($model) {
		if(!isset($model)){
			return null;
		}
		$method = str_replace('-', '', $this->action).'Action';
		if (method_exists($model, $method)) {
			return $method;
		}
		return null;
	}
	/**
	 * Retrieves URL segments that come after the specified action in the current URL.
	 *
	 * This function parses the current URL and returns an array of segments that follow
	 * the action segment. It is useful for extracting additional path information
	 * in a MVC framework structure.
	 *
	 * @return array Returns an array of URL segments after the action.
	 */
	public function getUrldata() : array {
		global $config;
		$result=[
			'controller' => $this->controller,
			'action' => $this->action,
		];
		$url = $_SERVER['REQUEST_URI'];
	
		// Remove the base path and query string from the URL
		$path = str_replace($config->baseUrlEnd, '', parse_url($url, PHP_URL_PATH));
	
		// Split the URL into segments
		$segments = explode('/', $path);
	
		// Find the position of the action in the segments
		$actionPosition = array_search($this->action, $segments);
	
		// Return segments after the action
		if ($actionPosition !== false && $actionPosition < count($segments) - 1) {
			$result['urlPathsAfterAction'] = array_slice($segments, $actionPosition + 1);
			return $result;
		}
	
		return $result;
	}	
	   /**
     * Check if the CSS file for the current controller exists.
     *
     * @return bool Returns true if the CSS file exists, false otherwise.
     */
    public function isCssDefined() {
		global $config;
        $cssFilePath =  $config->basePath. "/assets/css/" . $this->controller . ".css";
        return file_exists($cssFilePath);
    }

    /**
     * Check if the JS file for the current controller exists.
     *
     * @return bool Returns true if the JS file exists, false otherwise.
     */
    public function isJsDefined() {
		global $config;
        $jsFilePath = $config->basePath . "/assets/js/" . $this->controller . ".js";
        return file_exists($jsFilePath);
    }
	public function isCacheEnabled(){
		global $config;
		if ($config->isProduction == 'no' && isset($config->isProduction)) {
			return '?'.time();
		} else {
			return '';
		}
	}
}