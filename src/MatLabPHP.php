<?php

/*
MatLabPHP
@author: Patricio Tarantino
@description: Using vectors and matrix syntaxis as MatLab to work in PHP.
@start-date: Sept 2012
*/

use \Malenki\Math\Stats\Stats;

namespace MatLabPHP;

class MatLabPHP
{

    public function __construct()
    {
        bcscale(10);
    }

    // To Return Error Msgs in methods
    private function errorMsg($msg)
    {
        $errorMsg = array(
            'BadFormat'       => 'Bad Format',
            'NotNum'          => 'Value in vector is not Numeric',
            'NotSameColsRows' => 'The cols in each row should be the same',
            'ArgsNum'         => 'Arguments must be numeric'
        );

        return $errorMsg[$msg];
    }

    /**
     * String to Vector:
     * @desc: Transform a vector in the format of [1 2 3] to an array(1,2,3);
     * @param: Number, Vector or Matrix. Ex: 1 or  [1 2 3] or [1 2 ; 3 4]
     * @return: Array of Number, Vector or Matrix to operate in the class.
     */
    public function stringToVector($vector)
    {
        if (is_array($vector)) {
            return $vector;
        } elseif (is_numeric($vector)) {
            return array($vector);
        } else {
            $vector = trim($vector);

            if (strpos($vector, ";")) { // If there are a few rows, then it is a matrix
                $rows = explode(";", $vector);
                foreach ($rows as $key => $row) {
                    if ($key == 0) {
                        $row = substr($row, 1);
                    } elseif ($key == count($rows)-1) {
                        $row = substr($row, 0, -1);
                    }
                    $returnVector[] = $this->stringToVector("[".$row."]");
                }
                // Array of the Matrix finished. We should check if it is consistent.
                $cols = count($returnVector[0]);
                foreach ($returnVector as $row) {
                    if (count($row) != $cols) {
                        return $this->errorMsg('NotSameColsRows');
                        end();
                    }
                }
                return $returnVector;
            } elseif ($vector[0] != "[" || $vector[strlen($vector)-1] != "]") { // Checking good format of [ numbers ]
                return $this->errorMsg('BadFormat');
                end();
            } else {
                $vector = trim(substr($vector, 1, -1));
                $values = explode(" ", $vector);
                foreach ($values as $value) {
                    if ($value != "") {
                        if (is_numeric(trim($value))) {
                            $vectorArray[] = trim($value);
                        } else {
                            return $this->errorMsg('NotNum');
                            end();
                        }
                    }
                }
                return $vectorArray;
            }
        }
    }

    /**
     * Eye:
     * @desc: Create the identity matrix;
     * @param: cols and rows.
     * @return: Eye matrix
     */
    public function eye($cols, $rows = 'eq')
    {
        $rows = ($rows == 'eq')? trim($cols) : trim($rows);
        $cols = trim($cols);

        if (!is_numeric($cols) || !is_numeric($rows)) {
            return $this->errorMsg('ArgsNum');
            end();
        }

        $matrix = array();
        for ($c = 1; $c <= $cols; $c++) {
            for ($r=1; $r<=$rows; $r++) {
                $matrix[$c][$r] = ($c == $r)? '1' : '0';
            }
        }
        return $matrix;


    }

    /**
     * Zeros:
     * @desc: Create the a matrix of zeros;
     * @param: cols and rows.
     * @return: Zero matrix
     */
    public function zeros($cols, $rows = 'eq')
    {
        $rows = ($rows == 'eq')? trim($cols) : trim($rows);
        $cols = trim($cols);

        if (!is_numeric($cols) || !is_numeric($rows)) {
            return $this->errorMsg('ArgsNum');
            end();
        }

        $matrix = array();
        for ($c=1; $c<=$cols; $c++) {
            for ($r=1; $r<=$rows; $r++) {
                $matrix[$c][$r] = '0';
            }
        }
        return $matrix;


    }

    /**
     * Length
     * @desc: Gives back the max between cols and rows of a matrix
     * @param: vector or matrix
     * @return: int
     */
    public function length($vector, $ret = 0)
    {
        $vector = $this->stringToVector($vector);
        if ($ret == 0) {
            return max(count($vector), count($vector[1]));
        } else {
            $rows = (isset($sumA[1])) ? count($sumA[1]) : 1;
            return array(count($vector),$rows);
        }
    }

    /**
     * Sum
     * @desc: Sumes two matrix or vectors or numbers
     * @param: two vector or matrix or numbers
     * @return: result
     */
    public function sum($sumA, $sumB)
    {
        $sumA    = $this->stringToVector($sumA);
        $sumB    = $this->stringToVector($sumB);
        $lengthA = $this->length($sumA, 1);
        $lengthB = $this->length($sumB, 1);

        if ($lengthA[0] != $lengthB[0] || $lengthA[1] != $lengthB[1]) {
            return $this->errorMsg('NotSameColsRows');
            end();
        }

        $cols = count($sumA);
        $rows = (isset($sumA[1])) ? count($sumA[1]) : 1;
        $matrix = array();

        for ($c = 0; $c < $cols; $c++) {
            for ($r = 0; $r < $rows; $r++) {
                $matrix[$c][$r] = ($sumA[$c][$r] + $sumB[$c][$r]);
            }
        }
        return $matrix;
    }

    /**
     * price2ret
     * @desc: Convert prices to returns -- http://www.mathworks.com/help/econ/price2ret.html
     * @param: vector with series price
     * @return: vector with returns
     */
    public function price2ret($seriesPrice)
    {
        $arr = new \ArrayIterator();

        foreach ($seriesPrice as $key => $value) {
            if ($key == 0) {
                $arr->offsetSet($value, null);
                continue;
            }

            $priceD0 = $seriesPrice[$key - 1];
            $return  = log($value/$priceD0);

            $arr->offsetSet($value, $return);
        }

        return $arr->getArrayCopy();
    }

    /**
     * @desc: Maximum value of timeseries dat
     * @ref: http://www.mathworks.com/help/matlab/ref/timeseries.max.html
     * @param: float[] A array or matrix
     * @return: float
     */
    public function max($vector)
    {
        return true;
    }

    /**
     * @desc: Minimum value of timeseries data
     * @ref: http://www.mathworks.com/help/matlab/ref/timeseries.min.html
     * @param: float[] A array or matrix
     * @return: float
     */
    public function min($vector)
    {
        return true;
    }

    /**
     * @desc: Convert prices to returns
     * @ref: https://nf.nci.org.au/facilities/software/Matlab/techdoc/ref/mean.html
     * @param: float[] A array or matrix
     * @return: float
     */
    public function meanOld($array)
    {
        $average = array_sum($array) / count($array);

        return $average;
    }

    /**
     * @desc: Standard deviation of timeseries data
     * @ref: http://www.mathworks.com/help/matlab/ref/timeseries.std.html
     * @param: float[] A array or matrix
     * @return: float
     */
    public function std($array, $isSample = false)
    {
        return $this->stddev($array, $isSample);
    }

  /**
     * General mathematical functions.
     */
    public function mathArraySum($array, &$count = null)
    {
        $sum = '0';
        $count = '0';
        foreach($array as $value) {
            if (is_numeric($value)) {
                $sum = bcadd($sum, (string) $value);
                $count = bcadd($count, '1');
            }
        }
        return $sum;
    }

    public function mathCount($array)
    {
        $c = '0';
        foreach($array as $value) {
            if (is_numeric($value)) {
                $c = bcadd($c, '1');
            }
        }
        return $c;
    }

    /**
     * Calculate mean (simple arithmetic average).
     *
     * @param array $values
     * @return string Mean
     */
    public function mean(array $values)
    {
        $sum = $this->mathArraySum($values, $n);
        return bcdiv($sum, $n);
    }

    /**
     * Calculate median.
     *
     * @param array $values
     * @return string Median value
     */
    public function median(array $values)
    {
        $values = array_values(array_map('strval', $values));
        sort($values, SORT_NUMERIC);
        $n = count($values);
        // exact median
        if (isset($values[$n/2])) {
            return $values[$n/2];
        }
        // average of two middle values
        $m1 = ($n-1)/2;
        $m2 = ($n+1)/2;
        if (isset($values[$m1]) && isset($values[$m2])) {
            return bcdiv(bcadd($values[$m1], $values[$m2]), '2');
        }
        // best guess
        $mrnd = (int) round($n/2, 0);
        if (isset($values[$mrnd])) {
            return $values[$mrnd];
        }
        return null;
    }

    /**
     * Calculate the sum of products.
     *
     * @param array $x_values
     * @param array $y_values
     * @return string Sum of products.
     */
    public function sumxy(array $x_values, array $y_values)
    {
        $sum = '0';
        foreach($x_values as $i => $x) {
            if (isset($y_values[$i])) {
                $sum = bcadd($sum, bcmul($x, $y_values[$i]));
                #$sum += $x * $y_values[$i];
            }
        }
        return (string) $sum;
    }

    /**
     * Compute the sum of squares.
     *
     * @param array $values An array of values.
     * @param null|scalar|array $values2 If null is given, squares each array value.
     * If given a scalar value, squares the difference between each array value and
     * the one given in $values2 (good for explained/regression SS).
     * If given an array, squares the difference between betweeen each array value
     * and the value in $values2 with matching key (good for residual SS).
     * @return string Sum of all da squares.
     */
    public function sos(array $values, $values2 = null)
    {
        if (isset($values2) && ! is_array($values2)) {
            $values2 = array_fill_keys(array_keys($values), $values2);
        }
        $sum = '0';
        foreach ($values as $i => $val) {
            if (! isset($values2)) {
                $sum = bcadd($sum, bcpow($val, '2'));
                #$sum += pow($val, 2);
            } else if (isset($values2[$i])) {
                $sum = bcadd($sum, bcpow(bcsub($val, $values2[$i]), '2'));
                #$sum += pow($val - $values2[$i], 2);
            }
        }
        return (string) $sum;
    }


    /**
     * @desc: Variance of timeseries data
     * @ref: http://www.mathworks.com/help/matlab/ref/timeseries.var.html
     * @param: float[] A array or matrix
     * @return: float
     */
    /**
     * Calculate variance.
     *
     * @param array $values
     * @param boolean $isSample Default false.
     * @return string Variance of the values.
     */
    public function variance(array $values, $isSample = false)
    {
        if ($isSample) {
            // = SOS(r) / (COUNT(s) - 1)
            return bcdiv($this->sos($values, $this->mean($values)),
                bcsub($this->mathCount($values), '1')
            );
        }
        return $this->covariance($values, $values);
    }

    /**
     * Compute standard deviation.
     *
     * @param array $a The array of data to find the standard deviation for.
     * Note that all values of the array will be cast to float.
     * @param bool $isSample [Optional] Indicates if $a represents a sample of the
     * population (otherwise its the population); Defaults to false.
     * @return string|bool The standard deviation or false on error.
     */
    public function stddev(array $a, $isSample = false)
    {
        if ($this->mathCount($a) < 2) {
            trigger_error("The array has too few elements", E_USER_NOTICE);
            return false;
        }
        return bcsqrt($this->variance($a, $isSample));
    }

    /**
     * Calculate covariance.
     *
     * @param array $x_values Dependent variable values.
     * @param array $y_values Independent variable values.
     * @return string Covariance of x and y.
     */
    public function covariance(array $x_values, array $y_values)
    {
        $l = bcdiv($this->sumxy($x_values, $y_values), $this->mathCount($x_values));
        $r = bcmul($this->mean($x_values), $this->mean($y_values));

        return bcsub($l, $r);

        #return sumxy($x_values, $y_values)/mathCount($x_values) - mean($x_values)*mean($y_values);
    }

    /**
     * Compute correlation.
     *
     * @param array   $x_values
     * @param array   $y_values
     * @param boolean $is
     * @return string Correlation
     */
    public function correlation(array $x_values, array $y_values, $isSample = false)
    {
        $stddevxy = bcmul($this->stddev($x_values, $isSample), $this->stddev($y_values, $isSample));

        return round(bcdiv($this->covariance($x_values, $y_values), $stddevxy), 8);
    }

    /**
     * Returns the present value of a cashflow.
     *
     * @param int|float|string $cashflow Numeric quantity of currency.
     * @param float|string $rate Discount rate
     * @param int|float|string $period A number representing time period in which the
     * cash flow occurs. e.g. for an annual cashflow, start a 0 and increase by 1
     * each year (e.g. [Year] 0, [Year] 1, ...)
     * @return string Present value of the cash flow.
     */
    public function pv($cashflow, $rate, $period = 0)
    {
        if ($period < 1) {
            return (string) $cashflow;
        }

        return bcdiv($cashflow, bcpow(bcadd($rate, '1'), $period));

        #return $cashflow / pow(1 + $rate, $period);
    }

    /**
     * Returns the Net Present Value of a series of cashflows.
     *
     * @param array $cashflows Indexed array of cash flows.
     * @param number $rate Discount rate applied.
     * @return string NPV of $cashflows discounted at $rate.
     */
    public function npv(array $cashflows, $rate)
    {
        $npv = "0.0";
        foreach ($cashflows as $index => $cashflow) {
            $npv += pv($cashflow, $rate, $index);
        }
        return (string) $npv;
    }

    /**
     * Returns the weighted average of a series of values.
     *
     * @param array $values Indexed array of values.
     * @param array $weights Indexed array of weights corresponding to each value.
     * @return string Weighted average of values.
     */
    public function weightedAvg(array $values, array $weights)
    {
        if (count($values) !== count($weights)) {
            trigger_error("Must pass the same number of weights and values.");
            return null;
        }
        $weighted_sum = "0.0";
        foreach ($values as $i => $val) {
            $weighted_sum += $val * $weights[$i];
        }
        return strval($weighted_sum/array_sum($weights));
    }

    /** ========================================
        Percentages
     ======================================== */

    /**
     * Returns the % of an amount of the total.
     *
     * e.g. for operating margin, use operating income as 1st arg, revenue as 2nd.
     * e.g. for capex as a % of sales, use capex as 1st arg, revenue as 2nd.
     *
     * @param number $portion An amount, a portion of the total.
     * @param number $total The total amount.
     * @return string %
     */
    public function pct($portion, $total)
    {
        return strval($portion/$total);
    }

    /**
     * Returns the % change between two values.
     *
     * @param number $current The current value.
     * @param number $previous The previous value.
     * @return string Percent change from previous to current.
     */
    public function pctChange($current, $previous)
    {
        return strval(($current - $previous) / $previous);
    }

    /**
     * Convert an array of values to % change.
     *
     * @param array $values Raw values ordered from oldest to newest.
     * @return array Array of the % change between values.
     */
    public function pctChangeArray(array $values)
    {
        $pcts = array();
        $keys = array_keys($values);
        $vals = array_values($values);
        foreach ($vals as $i => $value) {
            if (0 !== $i) {
                $prev = $vals[$i-1];
                if (0 == $prev) {
                    $pcts[$i] = '0';
                } else {
                    $pcts[$i] = strval(($value-$prev)/$prev);
                }
            }
        }
        array_shift($keys);
        return array_combine($keys, $pcts);
    }

    /** ========================================
        Aliases
     ======================================== */

    /**
     * Arithmetic average.
     */
    public function avg(array $values)
    {
        return strval(array_sum($values)/count($values));
    }

    /**
     * Covariance
     */
    public function covar(array $xvals, array $yvals)
    {
         return $this->covariance($xvals, $yvals);
    }

    /**
     * Standard deviation
     */
    public function stdev(array $values, $isSample = false)
    {
         return $this->stddev($values, $isSample);
    }

    /**
     * Correlation
     */
    public function correl(array $x_values, array $y_values, $isSample = false)
    {
         return $this->correlation($x_values, $y_values, $isSample);
    }
}
