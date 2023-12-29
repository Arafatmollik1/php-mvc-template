<?php

use PHPUnit\Framework\TestCase;
use Controllers\Index;

class IndexTest extends TestCase {
    public function testAdd() {
        $index = new Index();
        
        // Testing the add method
        $result1 = $index->add(1, 1);
        $this->assertEquals(2, $result1, 'Expected 1 + 1 to equal 2 but got ' . $result1);
    
        $result2 = $index->add(2, 2);
        $this->assertEquals(4, $result2, 'Expected 2 + 2 to equal 4 but got ' . $result2);
    }
}
