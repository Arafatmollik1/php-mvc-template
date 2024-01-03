<?php 
    require('app.php');

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");

    $apiHelper = new Src\Utility\LocalApi();
    // Process API request
    $apiHelper->processApiRequest();

?>
    

