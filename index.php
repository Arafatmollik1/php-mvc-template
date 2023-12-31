<?php 
    require('app.php');
    // Get controller model
    $controllerModel = $actionHandler->getControllerModel();
    // Check if action exists
    $controllerAction = $actionHandler->getControllerAction($controllerModel);
    if (false === $controllerAction) {
      echo '<script type="text/javascript">console.log("Controller action is not found #4721")</script>';
      header("HTTP/1.0 404 Not Found");
      exit();
    }

  /**
   * Execute current action and store result in $currentController
   * $currentController is accessible in template file
   */
    $serverData = $controllerModel->$controllerAction();

    $includeFrontend = "frontend/".$actionHandler->getController()."/".$actionHandler->getAction().".php" ;

    //This is the basic layout
    include 'views/head.php';
    include 'views/header.php';
    include($includeFrontend); //main body
    include 'views/footer.php';

?>