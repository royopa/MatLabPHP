<?php

require __DIR__ . '/../src/MatLabPHP.php';

use MatLabPHP\MatLabPHP;

class MatLabPHPTest extends \PHPUnit_Framework_TestCase
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
        $matLab = $this->getMatLabObject();

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
        $matLab = $this->getMatLabObject();

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
        $matLab = $this->getMatLabObject();

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
        $matLab = $this->getMatLabObject();

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
        $matLab = $this->getMatLabObject();

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
        $matLab = $this->getMatLabObject();

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

    public function testMean()
    {
        $matLabPHP = $this->getMatLabObject();

        $retFundoX = array(2, 1.5, -2.4, 1.5, 4, 1.2);
        $mediaRetX = $matLabPHP->mean($retFundoX);
        $this->assertEquals($mediaRetX, 1.3000000000);

        $mediaRetX = $matLabPHP->avg($retFundoX);
        $this->assertEquals($mediaRetX, 1.3000000000);

        $retFundoY = array(-1.2, 0.2, 1.3, 0, -2, 0.5);
        $mediaRetY = $matLabPHP->mean($retFundoY);
        $this->assertEquals($mediaRetY, -0.2000000000);

        $mediaRetY = $matLabPHP->avg($retFundoY);
        $this->assertEquals($mediaRetY, -0.2000000000);
    }

    public function testStd()
    {
        $matLabPHP = $this->getMatLabObject();

        $retFundoX = array(2, 1.5, -2.4, 1.5, 4, 1.2);

        $desvPadX  = $matLabPHP->std($retFundoX, true);
        $this->assertEquals($desvPadX, 2.0765355763);

        $desvPadX  = $matLabPHP->stdev($retFundoX, true);
        $this->assertEquals($desvPadX, 2.0765355763);

        $retFundoY = array(-1.2, 0.2, 1.3, 0, -2, 0.5);

        $desvPadY  = $matLabPHP->std($retFundoY, true);
        $this->assertEquals($desvPadY, 1.1983321743);

        $desvPadY  = $matLabPHP->stdev($retFundoY, true);
        $this->assertEquals($desvPadY, 1.1983321743);
    }

    public function testVariance()
    {
        $matLabPHP = $this->getMatLabObject();

        $retFundoX = array(2, 1.5, -2.4, 1.5, 4, 1.2);
        $result    = $matLabPHP->variance($retFundoX, true);
        $this->assertEquals($result, 4.3120000000);

        $retFundoY = array(-1.2, 0.2, 1.3, 0, -2, 0.5);
        $result    = $matLabPHP->variance($retFundoY, true);
        $this->assertEquals($result, 1.4360000000);
    }

    public function testCovariance()
    {
        $matLabPHP = $this->getMatLabObject();

        $retFundoX = array(2, 1.5, -2.4, 1.5, 4, 1.2);
        $retFundoY = array(-1.2, 0.2, 1.3, 0, -2, 0.5);

        $result    = $matLabPHP->covariance($retFundoX, $retFundoY);
        $this->assertEquals($result, -1.8433333333);

        $result    = $matLabPHP->covar($retFundoX, $retFundoY);
        $this->assertEquals($result, -1.8433333333);
    }

    public function testCorrelation()
    {
        $matLabPHP = $this->getMatLabObject();

        $retFundoX = array(2, 1.5, -2.4, 1.5, 4, 1.2);
        $retFundoY = array(-1.2, 0.2, 1.3, 0, -2, 0.5);

        $isSample  = false;
        $result    = $matLabPHP->correlation($retFundoX, $retFundoY, $isSample);
        $this->assertEquals($result, -0.88893197);

        $result = $matLabPHP->correl($retFundoX, $retFundoY, $isSample);
        $this->assertEquals($result, -0.88893197);

        $isSample  = true;
        $result    = $matLabPHP->correlation($retFundoX, $retFundoY, $isSample);
        $this->assertEquals($result, -0.74077664);

        $result = $matLabPHP->correl($retFundoX, $retFundoY, $isSample);
        $this->assertEquals($result, -0.74077664);
    }

    public function getMatLabObject()
    {
        $matLab = new MatLabPHP();
        $this->assertMatLabPHP($matLab);

        return $matLab;
    }
}
