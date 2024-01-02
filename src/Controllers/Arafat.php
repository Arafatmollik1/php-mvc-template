<?php

namespace Controllers;

use Utility\SqlBuilder;

class Arafat
{
    public $userName;
    public $userEmail;
    public $userPhone;
    public $userAddress;
    public $queryResult;

    public function getuserinfoAction()
    {
        $crudify = new SqlBuilder(); // Create a new instance of SqlBuilder class
        $sql = $_GET['name']; // Retrieve the 'name' parameter from the URL query string
        
        // Build and execute a SQL query to read data where the 'name' column matches the $sql variable
        $this->queryResult = $crudify->read('*')->from('practiceUserInfo')->where("name='$sql'")->execute(); 
        $info = $this->queryResult[0]; // Get the first record from the query result

        // Assign various user information to the respective properties of this object
        $this->userName = $info['name'];
        $this->userEmail = $info['email'];
        $this->userPhone = $info['phone'];
        $this->userAddress = $info['address'];
        return $this; // Return the current object instance
    }
    
    public function insertuserdataAction()
    {
        $crudify = new SqlBuilder(); // Create a new instance of SqlBuilder class
        
        // Create an associative array with user data, getting values from URL query string
        // If a value is not provided, it defaults to 'undefined'
        $insert = [
            'name' => $_GET['name'] ?? 'undefined',
            'email' => $_GET['email'] ?? 'undefined',
            'phone' => $_GET['phone'] ?? 'undefined',
            'address' => $_GET['address'] ?? 'undefined',
        ];

        // Build and execute an INSERT SQL statement using the data from $insert array
        $this->queryResult = $crudify->create($insert)->from('practiceUserInfo')->execute();
        return $this; // Return the current object instance
    }

}