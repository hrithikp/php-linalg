<?php

namespace LinAlg;

function toFloat($x)
{
    return floatval($x);
}

class Vector implements \Iterator, \Countable
{
    private $index = 0;
    private $store;
    private $parser;
    public function __construct(array $data, $parser = null)
    {
        $this->parser = $parser;
        $this->store = new \SplFixedArray(count($data));
        foreach ($data as $index => $value)
        {
            $this->store[$index] = $this->parse($value);
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
    private function parse($x)
    {
        $out = null;
        if (is_callable($this->parser))
        {
            $out = call_user_func($this->parser, $x);
        }
        if (is_int($out) || is_float($out))
        {
            return $out;
        }
        else 
        {
            return floatval($x);
        }
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
                $out[$i] = call_user_func($op, $this->store[$i], $x, $i);
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
    public function sub(Vector $inp)
    {
        if (!$this->hasdim($inp))
        {
            throw new \InvalidArgumentException("Cannot subtract vectors of diff lengths");
        }
        $op = function ($a, $b) { 
          return $a - $b; 
        };
        $out = $this->run($op, $inp);
        return new Vector($out);
    }
    public function mul($k)
    {
        $k = $this->parse($k);
        $op = function ($x, $c) { 
          return $c * $x; 
        };

        $out = $this->run($op, $k);
        return new Vector($out);
    }
    public function abs()
    {
        $n = $this->run(function ($x) {
            return $x * $x;
        });
        return sqrt(array_sum($n));
    }
    public function len($type='euclid') 
    {
        return $this->abs();
    }
}