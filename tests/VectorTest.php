<?php

use LinAlg\Vector as Vector;
class VectorTest extends BaseTestCase
{
    public function testVectorCreate()
    {
        $raw = array();
        $dim = rand($this->minDim,$this->maxDim);
        for ($d = 0; $d < $dim; $d++)
        {
            $raw[$d] = rand($this->minNum, $this->maxNum);
        }
        $A = new Vector($raw);
        $this->assertInstanceOf('LinAlg\Vector', $A);
        $this->assertEquals(count($A), count($raw));
        foreach($A as $i => $a)
        {
            $this->assertEquals($raw[$i], $a);
        }
    }
}