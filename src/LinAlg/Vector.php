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
    private function hasdim(Vector $X)
    {
        return count($X) === $this->count();
    }
    private function run($op, $X = null, $out = array())
    {
        if ($X === null || !($X instanceof Vector))
        {
            foreach($this->store as $i => $v)
            {
                $out[] = $op($this->store[$i], $X, $i);
            }
        }
        else 
        {
            foreach($X as $i => $x)
            {
                $out[$i] = $op($this->store[$i], $x, $i);
            }            
        }
        return $out;
    }
    public function add(Vector $inp)
    {
        if (!$this->hasdim($inp))
        {
            throw new \InvalidArgumentException("Cannot add vectors of diff lengths");
        }
        $op = function ($a, $b) { 
          return $a + $b; 
        };
        $out = $this->run($op, $inp);
        return new Vector($out);
    }
}