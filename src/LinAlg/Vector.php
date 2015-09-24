<?php

namespace LinAlg;

class Vector implements \Iterator, \Countable
{
    private $index = 0;
    private $store;
    private $parser;
    /**
     * Creates a new Vector object
     * @param array  $data   List of values to populate
     * @param callable [$parser] A function that maps a data value to a numerical value, Defaults: floatval()
     */
    public function __construct(array $data, $parser = null)
    {
        $this->parser = $parser;
        $this->store = new \SplFixedArray(count($data));
        foreach ($data as $key => $val)
        {
            $this->store[$key] = $this->parse($val);
        }
        $this->index = 0;
    }

    // - Basic Vector operations that produce vectors
    
    /**
     * Adds the passed vector and returns a new vector
     * @param Vector $inp An input vector of matching dimensions
     * @return Vector $out A new vector resulting from the operation
     */
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
    /**
     * Subtracts the passed vector and returns a new vector
     * @param Vector $inp An input vector of matching dimensions
     * @return Vector $out A new vector resulting from the operation
     */
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
    /**
     * Subtracts the passed vector and returns a new vector
     * @param mixed $k An input value that is parsed and used to scale the vector
     * @return Vector $out A new vector resulting from the operation
     */
    public function mul($k)
    {
        $op = function ($x, $c) { 
          return $c * $x; 
        };

        $out = $this->run($op, $k);
        return new Vector($out);
    }

    // - Advanced Vector Operations that produce scalars or Vectors
    
    /**
     * Calculate the magnitude of the vector
     * @return float
     */
    public function abs()
    {
        $n = $this->run(function ($x) {
            return $x * $x;
        });
        return sqrt(array_sum($n));
    }
    /**
     * Calculate the dot product with the passed vector
     * @param  Vector $inp An input vector of matching dimensions
     * @return float
     */
    public function dot(Vector $inp)
    {
        if (!$this->hasdim($inp))
        {
            throw new \InvalidArgumentException("Cannot dot vectors of diff lengths");
        }
        $op = function ($a, $b)
        {
            return $a * $b;
        };
        $out = $this->run($op, $inp);
        return array_sum($out);
    }
    /**
     * Alias for abs()
     * @return float
     */
    public function len() 
    {
        return $this->abs();
    }

    // - Private methods
    
    /**
     * An internal wrapper around the parser provided on create.
     * The parser function given MUST return a numerical value.
     * In the event that a non numerical value is encountered,
     * default is set to native: floatval
     * @param  mixed $x A value to parse
     * @return int|float A value that was parsed using user parser or default parser
     */
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
    /**
     * Checks to see if the passed vector matches dimentionality
     * @param  Vector $X An input vector to check for dimensionality
     * @return bool
     */
    private function hasdim(Vector $X)
    {
        return count($X) === $this->count();
    }

    /**
     * Runs the operation on the given vector or scalar
     * @param  callable $op  An operator function that accepts ($A[$i], $B[$i], $i) and returns a number
     * @param  mixed [$X]   If a Vector is passed then runs $op on matching $i, else runs $op on self with parsed $X
     * @return array An output array containing results of the operation
     */
    private function run($op, $X = null)
    {
        $out = array();
        if ($X === null || !($X instanceof Vector))
        {
            foreach($this->store as $i => $v)
            {
                $out[] = call_user_func($op, $this->store[$i], $this->parse($X), $i);
            }
        }
        else 
        {
            foreach($X as $i => $x)
            {
                $out[$i] = call_user_func($op, $this->store[$i], $this->parse($x), $i);
            }            
        }
        return $out;
    }
    // - Iterator Interface Methods
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
    // - Countable Interface Methods
    public function count()
    {
        return count($this->store);
    }
}