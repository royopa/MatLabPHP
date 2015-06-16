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

or

    composer require royopa/mat-lab-php

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
```php
$matLabPHP->stringToVector(string $str);
```
- description
    - Transform a vector in the format of [1 2 3] to an array(1,2,3);
- parameters
    - Number, Vector or Matrix. Ex: 1 or  [1 2 3] or [1 2 ; 3 4]
- return
    - Array of Number, Vector or Matrix to operate in the class.

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
```php
$matLabPHP->eye($cols, $rows = 'eq');
```
- description
    - Create the identity matrix;
- parameters
    - cols and rows.
- return
    - Eye matrix

#### zeros()
```php
$matLabPHP->zeros($cols, $rows = 'eq');
```
- description
    - Create the a matrix of zeros;
- parameters
    - cols and rows.
- return
    - Zero matrix

#### length()
```php
$matLabPHP->length($vector, $ret = 0);
```
- description
    - Gives back the max between cols and rows of a matrix
- parameters
    - vector or matrix
- return
    - int

#### sum()
```php
$matLabPHP->sum($sumA, $sumB);
```
- description
    - Sumes two matrix or vectors or numbers
- parameters
    - two vector or matrix or numbers
- return
    - result

#### mean()
```php
$matLabPHP->mean($array);
```
- description
    - Calculate mean (simple arithmetic average).
- parameters
    - array $values
- return
    - string Mean

#### stddev()
```php
$matLabPHP->stddev(array $a, $isSample = false);
```
- description
    - 
- parameters
    - 
- return
    - 

#### variance()
```php
$matLabPHP->variance($a, $isSample);
```
- description
    - 
- parameters
    - 
- return
    - 

#### covariance()
```php
$matLabPHP->covariance(array $x_values, array $y_values);
```
- description
    - 
- parameters
    - 
- return
    - 

#### correlation()
```php
$matLabPHP->correlation(array $x_values, array $y_values, $isSample = false);
```
- description
    - 
- parameters
    - 
- return
    - 

## Tests

From the project directory, tests can be ran using `phpunit`
