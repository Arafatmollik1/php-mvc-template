<?php

namespace Controllers;

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
   * Fautly code
   */
  public function add($a, $b) {
    return $a + ($b + 1);
  }

}