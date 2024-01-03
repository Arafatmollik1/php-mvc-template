<?php

namespace Src\Controllers;
use Src\Utility\SqlBuilder;

class Index {

  public function __construct() {
    return $this;
  }

  /**
   * Index page
   * @return $this
   */
  public function indexAction() {
    return $this;
  }
  /**
   * For Unit testing
   */
  public function getUserInfo($tablename) { 
    $result = (new SqlBuilder)->read("*")->from($tablename)->execute();
    return $result;
  }

}