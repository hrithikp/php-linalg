<?php

namespace LinAlg;

class Vector implements \Iterator, \Countable
{
    private $store;
    private $index = 0;
    public function __construct(array $data)
    {
        $this->store = new \SplFixedArray(count($data));
        foreach ($data as $index => $value)
        {
            $this->store[$index] = intval($value);
        }
        $this->index = 0;
    } 
    public function current() 
    {
        return $this->store[$this->index];
    }
    public function key() 
    {
        return $this->index;
    }
    public function next()
    {
        ++$this->index;
    }
    public function rewind()
    {
        $this->index = 0;
    }
    public function valid()
    {
        return isset($this->store[$this->index]);
    }
    public function count()
    {
        return count($this->store);
    }
}