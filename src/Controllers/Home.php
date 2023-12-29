<?php

namespace Controllers;
use Utility\SqlBuilder;

class Home {

  public function __construct() {
    return $this;
  }

  /**
   * Index page
   * @return $this
   */
  public function indexAction() {
/*     $crudify = new SqlBuilder();
    $insert = [
      'id' => '02',
      'userId' => 'sadasda',
      'email' => 'mollik@mollik.com',
      'name' => 'mollik'
    ];
    $update = [
      'id' => '03',
    ]; */
    // $result = $crudify->create($insert)->from('users')->execute();
    // $result = $crudify->read('*')->from('users')->where("id='02'")->execute();
    // $result = $crudify->update($update)->from('users')->where("id='02'")->execute();
    // $result = $crudify->read('*')->from('users')->execute();
    // $result = $crudify->delete()->from('users')->where("id = '03'")->execute();
    // $result = $crudify->read('*')->from('users')->execute(); 
/*     echo "<pre>";
    var_dump($result);
    echo "</pre>"; */
    return $this;
  }

}