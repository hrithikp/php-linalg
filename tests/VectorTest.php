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
        $X = new Vector($raw, function ($x) {
            return intval($x);
        });
        $this->assertInstanceOf('LinAlg\Vector', $X);
        $this->assertEquals(count($X), count($raw));
        foreach($X as $i => $x)
        {
            $this->assertEquals($raw[$i], $x);
        }
    }

    public function testVectorAdd()
    {
        $vec0 = new Vector([0, 0, 0, 0]);
        $vec1 = new Vector([1, 2, 3]);

        $this->setExpectedException(
          'InvalidArgumentException', 'Cannot add vectors of diff lengths'
        );
        $error = $vec1->add($vec0);

        $vec2 = new Vector([4, 5, 6]);
        $ans = [5, 7, 9];
        $vec3 = $vec1->add($vec2);

        foreach($vec3 as $i => $v)
        {
            $this->assertEquals($v, $ans[$i]);
        }
    }

    public function testVectorSub()
    {
        $vec0 = new Vector([0, 0, 0, 0]);
        $vec1 = new Vector([1, 2, 3]);

        $this->setExpectedException(
          'InvalidArgumentException', 'Cannot subtract vectors of diff lengths'
        );
        $error = $vec1->sub($vec0);

        $vec2 = new Vector([4, 5, 6]);
        $ans = [-3, -3, -3];
        $vec3 = $vec1->sub($vec2);

        foreach($vec3 as $i => $v)
        {
            $this->assertEquals($v, $ans[$i]);
        }
    }

    public function testVectorMul()
    {
        $vec1 = new Vector([1, 2, 3]);
        $ans = [3, 6, 9];
        $vec2 = $vec1->mul(3);
        foreach($vec2 as $i => $v)
        {
            $this->assertEquals($v, $ans[$i]);
        }
    }
    public function testVectorAbs()
    {
        $vec = new Vector([1, 1]);
        $ans = sqrt(2);
        $this->assertEquals($vec->abs(), $ans);
    }
}