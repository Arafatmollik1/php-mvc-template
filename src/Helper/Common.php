<?php

namespace Src\Helper;

class Common
{
  public $autoLoad = '';

  public function __construct()
  {
    
  }



  public function setAutoLoad($isLoad = false)
  {
    if ($isLoad) {
      $this->autoLoad = 'autoLoad';
      return $this->autoLoad;
    }
    $this->autoLoad = '';
  }

  /**
   * Check if used is logged in
   * @return boolean
   */
  public function isLoggedIn() {
    /* if (isset($_SESSION)) {
      if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
        return true;
      }
    } */
    return false;
  }
  /**
   * Get user data in decrypted format
   * @return array
   */
  protected function getUser() {
    $result = array();
    
    return $result;
  }


  /**
   * Generates a random number and takes in integer number to determine the size
   * @param int
   * @return string
   */
  public function generateRandomNumber($digits){
    $randomNumber = mt_rand(0, pow(10, $digits) - 1);
    return sprintf("%0" . $digits . "d", $randomNumber);
  }



  /**
   * Check email's validity
   * @param string Email to be validated
   * @return bool
   */
  public function isEmailValid($email){
    list($user, $domain) = explode('@', $email);
    $validAddress=checkdnsrr($domain, 'MX');
    if (false == filter_var($email, FILTER_VALIDATE_EMAIL) || $validAddress == false) {
      return false;
    }
    return true;
  }

  
  /**
   * Change the formate of date from Y-M-D to D-M-Y
   * @param string date in the formate of Y-M-D
   * @return string
   */
  public function changeDateFormat($date){
    $fomattedDate = date('d-m-Y', strtotime($date));
    return $fomattedDate;
  }
  public function changeDateToWeekday($date){
    $dayOfWeek = date('D', strtotime($date));
    return strtoupper($dayOfWeek);
  }
}
