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

		$routePath = trim(str_replace($path, '', $uri), '/');

		$segments = explode('/', $routePath);

		$this->controller = (!isset($segments[0]) || empty($segments[0])) ? 'index' : $segments[0];
		$this->action = $segments[1] ?? 'index';


		return [
			'controller' => $this->controller,
			'action' => $this->action,
			'params' => array_slice($segments, 2)
		];
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
			throw new \Exception("Controller not found: " . $className);
		}

		$classModel = new $className;
		return $classModel;
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