<?php
use Src\Controllers\Index;
test('example', function () {
    $index = new Index();
        
    // Testing the add method
    $result1 = $index->getUserInfo('users');
    var_dump($result1);
    expect($result1)->not->toBeEmpty();
});
