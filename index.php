<?php
  require('app.php');
  // Get controller model
  $controllerModel = $actionHandler->getControllerModel();
  // Check if action exists
  $controllerAction = $actionHandler->getControllerAction($controllerModel);
  if (!isset($controllerAction)) {
    http_response_code(404);
    include 'views/404page.php';
    exit();
  }
  global $urlData;
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