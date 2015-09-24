<?php

use LinAlg\Vector as Vector;
class VectorTest extends BaseTestCase
{
    public function testVectorCreate()
    {
        $raw = [1,1];
        $A = new Vector($raw);
        $this->assertInstanceOf('LinAlg\Vector', $A);
        $this->assertEquals(count($A), count($raw));
        foreach($A as $i => $a)
        {
            $this->assertEquals($raw[$i], $a);
        }
    }
}