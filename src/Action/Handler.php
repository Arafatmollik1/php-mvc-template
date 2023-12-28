<?php

namespace Action;

/**
 * Request validator and action handler
 */
class Handler
{

	// Current request URI
	public $uri = '';

	// Current request path
	public $path = array();

	// Current script being executed
	public $script = '';

	// Current page action
	public $action = 'index';

	// Current controller
	public $controller = 'index'; // default index

	public $controllerModel = '';

	// Controller model name
	public $model = '';

	// Config of current view
	protected $config = array();

	// Controller config
	protected $controllerConfig = array();

	public function __construct() {

            $scriptName = basename($_SERVER["SCRIPT_NAME"]);
			// Current script being executed
			$this->setScript($scriptName);

			// Current request URI
			$this->setUri();

			// Current path
			$this->setPath();

			// Get action configuration
			$this->getControllerConfig();

			// Current script action
			$this->setAction();

			// Set properties on current controller
			$this->setControllerProperties();
		
	}

	/**
	 * Load config
	 * @return null
	 */
	private function getControllerConfig() {
		global $config;
		if (isset($config->controllers)) {
			$actions = $config->controllers;
			$this->controllerConfig = $actions;
		} else {
            "getControllerConfig not working";
		}
	}


	/**
	 * Set path based on current URI
	 * @return null
	 */
	protected function setPath() {
		if (isset($_SERVER["REQUEST_URI"]) && !empty($_SERVER["REQUEST_URI"])) {
			$paths = preg_split('@/@', $this->uri, NULL, PREG_SPLIT_NO_EMPTY);
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
			$this->uri = strtok($_SERVER["REQUEST_URI"], '?');
		} else {
			$this->uri = $_SERVER["SCRIPT_NAME"];
            echo 'setUri is set to script name';
		}
	}


	/**
	 * Set script being executed
	 * @param string $script
	 * @return null
	 */
	protected function setScript($script) {
		$this->script = $script;
	}

	/**
	 * Set action
	 * @return null
	 */
	protected function setAction() {
		if (is_array($this->path) && sizeof($this->path) > 1) {
            if(!isset($this->path[2])){
                $this->action = 'index';
            }
            else{
                $this->action = strtolower($this->path[2]);
            }
		}
	}

	/**
	 * Get properties from current controller
	 * @return null
	 */
	protected function setControllerProperties() {
		if (is_array($this->path) && sizeof($this->path) > 0) {
			$controllers = array_keys($this->controllerConfig);
			if (!in_array(strtolower($this->path[1]), $controllers)) {
                echo 'something wrong #4512';
			} else {
				$this->controller 	= strtolower($this->path[1]);
				if (isset($this->controllerConfig[$this->controller]['model'])) {
					$this->model			= $this->controllerConfig[$this->controller]['model'];
				}
			}
		}
	}


	/**
	 * Retrieve URI
	 * @return string
	 */
	public function getUri() {
		return $this->uri;
	}

	/**
	 * Retrieve execution script
	 * @return string
	 */
	public function getScript() {
		return $this->script;
	}

	/**
	 * Retrieve current controller
	 * @return string
	 */
	public function getController() {
		return $this->controller;
	}

	/**
	 * Get controller view name
	 * @return string
	 */
	public function getControllerView() {
		//return str_replace('-', '', $this->controller);
		return $this->controller;
	}

	/**
	 * Retrieve controller template file
	 * @return string
	 */
	public function getTemplate() {
		global $config;

		// Build path
		$path 	= $config->app['template_dir'];
		$ds 		= DIRECTORY_SEPARATOR;
		$file 	= $this->getControllerView();
		$ext 		= '.php';

		return $path.$ds.$file.$ext;
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
		if (!empty($this->model)) {
            $className = "Controllers" . "\\" . $this->model;
            $this->controllerModel = $className;

            // Init controller class
            $classModel = new $className;
            return $classModel;
        }
		return false;
	}

	/**
	 * Get controller action model
	 * @return string
	 */
	public function getControllerAction($model) {
		$method = str_replace('-', '', $this->action).'Action';
		if (method_exists($model, $method)) {
			return $method;
		}
		return false;
	}

}