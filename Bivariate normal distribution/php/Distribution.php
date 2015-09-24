<?php

/**
 * Statis Class Distribution
 *
 */
class Distribution
{

    ////////////////////////////////////////////
    /**
     * average
     *
     * Takes the arithmetic mean of an array of numeric values.
     * Non-numeric values are treated as zeroes.
     *
     * @param array $data An array of numeric values
     * @return float The arithmetic average of the elements of the array
     * @static
     */
    public static function average(array $data) {
        return self::sum($data) / count($data);
    }

    /**
     * sum
     *
     * Sums an array of numeric values. Non-numeric values
     * are treated as zeroes.
     *
     * @param array $data An array of numeric values
     * @return float The sum of the elements of the array
     * @static
     */
    public static function sum(array $data)
    {
        $sum = 0;
        foreach ($data as $element) {
            if (is_numeric($element)) {
                $sum += $element;
            }
        }
        return $sum;
    }


    /**
     * sumXY
     *
     * Returns the sum of products of paired variables in a pair of arrays
     * of numeric values. The two arrays must be of equal length.
     * Non-numeric values are treated as zeroes.
     *
     * @param array $datax An array of numeric values
     * @param array $datay An array of numeric values
     * @return float The products of the paired elements of the arrays
     * @static
     */
    public static function sumXY(array $datax, array $datay)
    {
        $n = min(count($datax), count($datay));
        $sum = 0.0;
        for ($count = 0; $count < $n; $count++) {
            if (is_numeric($datax[$count])) {
                $x = $datax[$count];
            } else {
//Non-numeric elements count as zero.
                $x = 0;
            }
            if (is_numeric($datay[$count])) {
                $y = $datay[$count];
            } else {
//Non-numeric elements count as zero.
                $y = 0;
            }
            $sum += $x * $y;
        }
        return $sum;
    }

    /**
     * sumSquared
     *
     * Returns the sum of squares of an array of numeric values.
     * Non-numeric values are treated as zeroes.
     *
     * @param array $data An array of numeric values
     * @return float The arithmetic average of the elements of the array
     * @static
     */
    public static function sumSquared(array $data)
    {
        $sum = 0;
        foreach ($data as $element) {
            if (is_numeric($element)) {
                $sum += pow($element, 2);
            }
        }

        return $sum;
    }

    /**
     * correlation P(x,y)
     * http://mathworld.wolfram.com/BivariateNormalDistribution.html :)
     * return p value
     *
     * @param $datax
     * @param $datay
     * @return float
     * @static
     */
    public static function correlation($datax, $datay)
    {
        $n = min(count($datax), count($datay));

        $sumDataX = self::sum($datax);

        $sumDataY = self::sum($datay);

        $sumDataXY = self::sumXY($datax, $datay);

        $sumSquaredDataX = self::sumSquared($datax);

        $sumSquaredDataY = self::sumSquared($datay);

        $res = ($n * $sumDataXY - $sumDataX * $sumDataY) / (sqrt($n * $sumSquaredDataX - pow($sumDataX, 2)) * sqrt($n * $sumSquaredDataY - pow($sumDataY, 2)));

        return $res;
    }

    /**
     * variance
     *
     * Returns the population variance of an array.
     * Non-numeric values are treated as zeroes.
     *
     * @param array $data An array of numeric values
     * @return float The variance of the supplied array
     * @static
     */
    public static function variance(array $data) {
        return self::covariance($data, $data);
    }

    /**
     * stdDev
     *
     * Returns the population standard deviation of an array.
     * Non-numeric values are treated as zeroes.
     *
     * @param array $data An array of numeric values
     * @return float The population standard deviation of the supplied array
     * @static
     */
    public static function stdDev(array $data) {
        return sqrt(self::variance($data));
    }

    /**
     * covariance
     *
     * Returns the covariance of two arrays. The two arrays must
     * be of equal length. Non-numeric values are treated as zeroes.
     *
     * @param array $datax An array of numeric values
     * @param array $datay An array of numeric values
     * @return float The covariance of the two supplied arrays
     * @static
     */
    public static function covariance(array $datax, array $datay) {
        return self::sumXY($datax, $datay) / count($datax) - self::average($datax) * self::average($datay);
    }

    /**
     * correlation
     * Returns the correlation of two arrays. The two arrays must
     * be of equal length. Non-numeric values are treated as zeroes.
     *
     * @param array $datax An array of numeric values
     * @param array $datay An array of numeric values
     * @return float The correlation of the two supplied arrays
     * @static
     */
    public static function correlation2($datax, $datay) {
        return self::covariance($datax, $datay) / (self::stdDev($datax) * self::stdDev($datay));
    }

    /**
     * Bivariante Normal Distribution ...
     * @param $datax
     * @param $datay
     * @param $x
     * @param $y
     * @return float
     */
    public static function bvnd($datax, $datay, $x, $y)
    {

        $muX = self::average($datax);
        $muY = self::average($datay);

        $sigmaX = self::stdDev($datax);
        $sigmaX2 = pow($sigmaX, 2);

        $sigmaY = self::stdDev($datay);
        $sigmaY2 = pow($sigmaY, 2);

        $p = self::correlation($datax, $datay);
        $p2 = pow($p, 2);


        $xMuX = $x - $muX;
        $yMuY = $y - $muY;

        $res1 = 1 / (2 * pi() * $sigmaX * $sigmaY * sqrt(1 - $p2));

        $e = -1 / ( 2 * ( 1 - $p2 )) * ( (pow($xMuX, 2) / $sigmaX2 ) + ( pow($yMuY, 2 ) / $sigmaY2 ) - (( 2 * $p * $xMuX * $yMuY ) / ( $sigmaX * $sigmaY )) );

        $exp = exp($e);

        $res = $res1 * $exp;

        return $res;

    }


}
