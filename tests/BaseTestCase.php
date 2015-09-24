<?php

class BaseTestCase extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->minDim = 2;
        $this->maxDim = 16;
        $this->minNum = 0;
        $this->maxNum = 1000;
    }
    public function tearDown()
    {
    }
}