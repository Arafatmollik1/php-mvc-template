<?php

namespace Controllers\Api\V2;

class Exampletwo {

    public function __construct() {
        return $this;
    }
    public function getusersAction($getParamas, $postParams, $jsonData){
        return "Now this is new one";
    }
}
