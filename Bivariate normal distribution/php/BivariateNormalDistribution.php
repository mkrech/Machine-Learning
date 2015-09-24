<?php

require_once('Distribution.php');

class BivariateNormalDistribution
{
    private $datax;
    private $datay;
    private $muX = 0;
    private $muY = 0;

    private $sigmaX = 1;
    private $sigmaX2 = 1;

    private $sigmaY = 1;
    private $sigmaY2 = 1;

    private $p = 0.8;
    private $p2 = 0.64;

    /**
     * init
     * @param array $datax
     * @param array $datay
     */
    public function init(array $datax, array $datay)
    {
        $this->datax = $datax;
        $this->datay = $datay;

        $this->muX = Distribution::average($this->datax);
        $this->muY = Distribution::average($this->datay);

        $this->sigmaX = Distribution::stdDev($this->datax);
        $this->sigmaX2 = pow($this->sigmaX, 2);

        $this->sigmaY = Distribution::stdDev($this->datay);
        $this->sigmaY2 = pow($this->sigmaY, 2);

        $this->p = Distribution::correlation($this->datax, $this->datay);
        $this->p2 = pow($this->p, 2);
    }

    /**
     * Compute
     * @param $x
     * @param $y
     * @return float
     */
    public function compute($x, $y)
    {
        $xMuX = $x - $this->muX;
        $yMuY = $y - $this->muY;

        $res1 = 1 / (2 * pi() * $this->sigmaX * $this->sigmaY * sqrt(1 - $this->p2));

        $e = -1 / ( 2 * ( 1 - $this->p2 )) * ( (pow($xMuX, 2) / $this->sigmaX2 ) + (pow($yMuY, 2 ) / $this->sigmaY2) - (( 2 * $this->p * $xMuX * $yMuY ) / ( $this->sigmaX * $this->sigmaY )) );

        $exp = exp($e);

        $res = $res1 * $exp;

        return $res;

    }

}
