<?php

require __DIR__ . '/../src/MatLabPHP.php';

use MatLabPHP\MatLabPHP;

class MatLabPHPTest extends PHPUnit_Framework_TestCase
{
    /**
     * Asserts that a variable is of a Stringy instance.
     *
     * @param mixed $actual
     */
    public function assertMatLabPHP($actual)
    {
        $this->assertInstanceOf('MatLabPHP\MatLabPHP', $actual);
    }

    public function testStringToVector()
    {
        $matLab = new MatLabPHP();
        $this->assertMatLabPHP($matLab);

        $result   = $matLab->stringToVector("[3 1 2; 5 4 7; 6 9 7]");
        $expected = array(
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

        $this->assertEquals($result, $expected);
    }

    public function testEye()
    {
        $matLab = new MatLabPHP();
        $this->assertMatLabPHP($matLab);

        $result   = $matLab->eye(4);
        $expected = array(
            1 => array(
                '1' => '1',
                '2' => '0',
                '3' => '0',
                '4' => '0'
            ),
            2 => array(
                '1' => '0',
                '2' => '1',
                '3' => '0',
                '4' => '0'
            ),
            3 => array(
                '1' => '0',
                '2' => '0',
                '3' => '1',
                '4' => '0'
            ),
            4 => array(
                '1' => '0',
                '2' => '0',
                '3' => '0',
                '4' => '1'
            )
        );
        $this->assertEquals($result, $expected);

        $result   = $matLab->eye(2, 3);
        $expected = array(
            1 => array(
                '1' => '1',
                '2' => '0',
                '3' => '0'
            ),
            2 => array(
                '1' => '0',
                '2' => '1',
                '3' => '0'
            )
        );
        $this->assertEquals($result, $expected);
    }

    public function testZeros()
    {
        $matLab = new MatLabPHP();
        $this->assertMatLabPHP($matLab);

        $result   = $matLab->zeros(2, 1);
        $expected = array(
            1 => array(
                '1' => '0',
            ),
            2 => array(
                '1' => '0',
            )
        );
        $this->assertEquals($result, $expected);

        $result   = $matLab->zeros(2);
        $expected = array(
            1 => array(
                '1' => '0',
                '2' => '0',
            ),
            2 => array(
                '1' => '0',
                '2' => '0',
            )
        );
        $this->assertEquals($result, $expected);

        $result   = $matLab->zeros(2, 3);
        $expected = array(
            1 => array(
                '1' => '0',
                '2' => '0',
                '3' => '0'
            ),
            2 => array(
                '1' => '0',
                '2' => '0',
                '3' => '0'
            )
        );
        $this->assertEquals($result, $expected);
    }

    public function testLength()
    {
        $matLab = new MatLabPHP();
        $this->assertMatLabPHP($matLab);

        $vector = array(
                '1' => '0',
                '2' => '4',
                '3' => '9',
                '4' => '10',
                '5' => '1',
                '6' => '2'
            );

        $result = $matLab->length($vector);
        $this->assertEquals($result, 6);

        $matrix = array(
            1 => array(
                '1' => '0',
                '2' => '0'
            ),
            2 => array(
                '1' => '0',
                '2' => '0',
                '3' => '0',
                '4' => '8'
            ),
            3 => array(
                '1' => '0',
                '2' => '0',
                '3' => '0'
            ),
            4 => array(
                '1' => '0',
                '2' => '0',
                '3' => '9',
                '4' => '1'
            )
        );

        $result = $matLab->length($matrix);
        $this->assertEquals($result, 4);
    }

    public function testSum()
    {
        $matLab = new MatLabPHP();
        $this->assertMatLabPHP($matLab);

        $expected = array(
            0 => array(
                0 => 13
            )
        );

        $result = $matLab->sum('5', '8');
        $this->assertEquals($result, $expected);

        $matLab = new MatLabPHP();
        $this->assertMatLabPHP($matLab);

        $expected = array(
            0 => array(
                0 => 9,
                1 => 4,
                2 => 6
            ),
            1 => array(
                0 => 12,
                1 => 7,
                2 => 6
            ),
            2 => array(
                0 => 15,
                1 => 3,
                2 => 7
            )
        );

        $result = $matLab->sum(
            '[1 3 2; 4 2 5; 6 1 4]',
            '[8 1 4; 8 5 1; 9 2 3]'
        );

        $this->assertEquals($result, $expected);
    }

    public function testPrice2Ret()
    {
        $matLab = new MatLabPHP();
        $this->assertMatLabPHP($matLab);

        $seriesPriceOne = array(10, 12, 13, 9, 11, 9);
        $result         = $matLab->price2ret($seriesPriceOne);

        $expected = array(
            10 => null,
            12 => 0.18232155679395,
            13 => 0.080042707673536,
            9 =>  -0.20067069546215,
            11 => 0.20067069546215
        );
        $this->assertEquals($result, $expected);
    }
}
