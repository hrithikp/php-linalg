<?php
require '../vendor/autoload.php';
use LinAlg\Vector;

$input = ['the', 'quick', 'brown', 'fox', 'jumps', 'over', 'the', 'lazy', 'dog'];

$lengths = new Vector($input, function ($x) {
  if (is_string($x)) {
    return strlen($x);
  } else {
    return 0;
  }
});
print_r($lengths);