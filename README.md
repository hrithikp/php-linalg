
# PHP Linear Algebra Library

Below is a list of existing functionality.

* Data Structures
	* Vector (Stable)
	* Matrix (Future)
* Operations
	* Vectors (Stable)
		* Addition
		* Subtraction
		* Scalar Multiplication
		* Calculate Magnitude or Absolute
		* Calculate Dot Product
	* Vectors (Future)
		* Calculate Determinant
		* Calculate Distance (Euclidean, Jaccard, etc.)
		
## Installation


Install using composer

```
curl -s http://getcomposer.org/installer | php
git clone https://github.com/hrithikp/php-linalg
cd php-linalg
/path/to/composer.phar update
```

## Testing
Uses phpunit for unit testing
```
./vendor/bin/phpunit
```

## Usage

Below is an example (wordlen.php) that uses a custom parser to populate a vector with string lengths.

```
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
```
```
$ php example/wordlen.php
LinAlg\Vector Object
(
    [index:LinAlg\Vector:private] => 0
    [store:LinAlg\Vector:private] => SplFixedArray Object
        (
            [0] => 3
            [1] => 5
            [2] => 5
            [3] => 3
            [4] => 5
            [5] => 4
            [6] => 3
            [7] => 4
            [8] => 3
        )

    [parser:LinAlg\Vector:private] => Closure Object
        (
            [parameter] => Array
                (
                    [$x] => <required>
                )

        )

)
```