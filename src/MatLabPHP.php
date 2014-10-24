<?php

/*
MatLabPHP
@author: Patricio Tarantino
@description: Using vectors and matrix syntaxis as MatLab to work in PHP.
@start-date: Sept 2012
*/

namespace MatLabPHP;

class MatLabPHP
{
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

    /*
    String to Vector:
    @desc: Transform a vector in the format of [1 2 3] to an array(1,2,3);
    @param: Number, Vector or Matrix. Ex: 1 or  [1 2 3] or [1 2 ; 3 4]
    @return: Array of Number, Vector or Matrix to operate in the class.
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

    /*
    Eye:
    @desc: Create the identity matrix;
    @param: cols and rows.
    @return: Eye matrix
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

    /*
    Zeros:
    @desc: Create the a matrix of zeros;
    @param: cols and rows.
    @return: Zero matrix
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

    /*
    Length
    @desc: Gives back the max between cols and rows of a matrix
    @param: vector or matrix
    @return: int
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

    /*
    Sum
    @desc: Sumes two matrix or vectors or numbers
    @param: two vector or matrix or numbers
    @return: result
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
}
