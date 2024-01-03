<?php

namespace Src\Controllers\Api\V1;

class Example {

    public function __construct() {
        return $this;
    }
    public function getusersAction($getParamas, $postParams, $jsonData){
        $data= [
            'Text' =>'This is from version1',
            'If you have any get params here it is' =>$getParamas,
            'If you have any post params here it is' =>$postParams,
            'If you have any json params here it is' =>$jsonData,
        ];
        return $data;
    }
}
