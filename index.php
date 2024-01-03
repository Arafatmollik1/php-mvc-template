<?php
  require('app.php'); //all global variables are set here
  $isMaintenanceMode = $config->maintenance['enabled']; 

  if ($isMaintenanceMode) {
      http_response_code(503); // 503 Service Unavailable
      include 'views/503page.php'; 
      exit();
  }
  $createNewSession=false;
  // Store user info in session
  if ($createNewSession) {
    echo 'new session start';
  }
  // Get controller model
  $controllerModel = $actionHandler->getControllerModel();
  // Check if action exists
  $controllerAction = $actionHandler->getControllerAction($controllerModel);
  if (!isset($controllerAction)) {
    http_response_code(404);
    include 'views/404page.php';
    exit();
  }
  $urlData = $actionHandler->getUrldata() ?? [];

  /**
   * Execute current action and store result in $currentController
   * $currentController is accessible in template file
   */
  $serverData = $controllerModel->$controllerAction();

  $includeFrontend = "frontend/" . $actionHandler->getController() . "/" . $actionHandler->getAction() . ".php";

  //This is the basic layout
  include 'views/head.php';
  include 'views/header.php';
  include($includeFrontend); //main body
  include 'views/footer.php';

?>