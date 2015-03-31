MatLabPHP
=========

[![Build Status](https://travis-ci.org/royopa/mat-lab-php.svg?branch=master)](https://travis-ci.org/royopa/mat-lab-php)

Some Math operations on PHP with MatLab syntaxis.

## Requiring/Loading

If you're using Composer to manage dependencies, you can include the following
in your composer.json file:

```json
{
    "require": {
        "royopa/mat-lab-php": "dev-master"
    }
}
```

Then, after running `composer update` or `php composer.phar update`, you can
load the class using Composer's autoloading:

```php
require 'vendor/autoload.php';
```

Otherwise, you can simply require the file directly:

```php
require_once 'path/to/MatLabPHP/src/MatLabPHP.php';
```

And in either case, I'd suggest using an alias.

```php
use MatLabPHP\MatLabPHP as M;
```

## Methods

#### stringToVector()

$matLabPHP->stringToVector(string $str);

@desc: Transform a vector in the format of [1 2 3] to an array(1,2,3);
@param: Number, Vector or Matrix. Ex: 1 or  [1 2 3] or [1 2 ; 3 4]
@return: Array of Number, Vector or Matrix to operate in the class.

```php
$matLabPHP = new MatLabPHP();
$matLabPHP->stringToVector("[3 1 2; 5 4 7; 6 9 7]");
    //array(
        0 => array(
            0 => '3',
            1 => '1',
            2 => '2'
        ),
        1 => array(
            0 => '5',
            1 => '4',
            2 => '7'
        ),
        2 => array(
            0 => '6',
            1 => '9',
            2 => '7'
        )
    );
```
#### eye()

$matLabPHP->eye($cols, $rows = 'eq');

@desc: Create the identity matrix;
@param: cols and rows.
@return: Eye matrix

#### zeros()

$matLabPHP->zeros($cols, $rows = 'eq');

@desc: Create the a matrix of zeros;
@param: cols and rows.
@return: Zero matrix

#### length()

$matLabPHP->length($vector, $ret = 0);

@desc: Gives back the max between cols and rows of a matrix
@param: vector or matrix
@return: int

#### sum()
```php
$matLabPHP->sum($sumA, $sumB);
```
@desc: Sumes two matrix or vectors or numbers
@param: two vector or matrix or numbers
@return: result

#### mean()
```php
$matLabPHP->mean($array);
```
@desc Calculate mean (simple arithmetic average).
@param array $values
@return string Mean

#### stddev()
```php
$matLabPHP->stddev(array $a, $isSample = false);
```
#### variance()
```php
$matLabPHP->variance($a, $isSample);
```
#### covariance()
```php
$matLabPHP->covariance(array $x_values, array $y_values);
```
#### correlation()
```php
$matLabPHP->correlation(array $x_values, array $y_values, $isSample = false);
```
## Tests

From the project directory, tests can be ran using `phpunit`
