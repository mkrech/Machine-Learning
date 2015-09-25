<?php
namespace mkrech\Distribution;

/**
 *
 * (c) M.Krech <m.krech@tisch2.de>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */


class NormalDistribution
{

    /**
     * arithmetic mean
     *
     * @param array $data_r
     * @return float
     */
    public function mean(array $data_r)
    {
        return $this->sum($data_r) / count($data_r);
    }

    /**
     * sum
     *
     * Sums an array of numeric values. Non-numeric values
     * are treated as zeroes.
     *
     * @param array $data_r
     * @return int|string
     */
    public function sum(array $data_r)
    {
        $sum = 0;
        foreach ($data_r as $element) {
            if (is_numeric($element)) {
                $sum += $element;
            }
        }
        return $sum;
    }


    /**
     * sumXY
     *
     * Returns the sum of products of paired variables in a pair of arrays.
     *
     * @param array $datax_r
     * @param array $datay_r
     * @return float|int
     */
    public function sumXY(array $datax_r, array $datay_r)
    {
        $n = min(count($datax_r), count($datay_r));
        $sum = 0.0;
        for ($count = 0; $count < $n; $count++) {
            if (is_numeric($datax_r[$count])) {
                $x = $datax_r[$count];
            } else {
//Non-numeric elements count as zero.
                $x = 0;
            }
            if (is_numeric($datay_r[$count])) {
                $y = $datay_r[$count];
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
     * @param array $data_r
     * @return int|number
     */
    public function sumSquared(array $data_r)
    {
        $sum = 0;
        foreach ($data_r as $element) {
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
     * @param $datax_r
     * @param $datay_r
     * @return float
     */
    public function correlation($datax_r, $datay_r)
    {
        $n = min(count($datax_r), count($datay_r));

        $sumDataX = $this->sum($datax_r);

        $sumDataY = $this->sum($datay_r);

        $sumDataXY = $this->sumXY($datax_r, $datay_r);

        $sumSquaredDataX = $this->sumSquared($datax_r);

        $sumSquaredDataY = $this->sumSquared($datay_r);

        $res = ($n * $sumDataXY - $sumDataX * $sumDataY) / (sqrt($n * $sumSquaredDataX - pow($sumDataX, 2)) * sqrt($n * $sumSquaredDataY - pow($sumDataY, 2)));

        return $res;
    }

    /**
     * variance
     *
     * Returns the population variance of an array.
     * Non-numeric values are treated as zeroes.
     *
     * @param array $data_r
     * @return float
     */
    public function variance(array $data_r)
    {
        return $this->covariance($data_r, $data_r);
    }

    /**
     * stdDev
     *
     * Returns the population standard deviation of an array.
     * Non-numeric values are treated as zeroes.
     *
     * Returns the population standard deviation of an array.
     *
     * Possible too but less precise
     * $res1 = sqrt($this->variance($data_r));
     *
     * @param array $data_r
     * @return float
     */
    public function stdDev(array $data_r)
    {
        $mean = $this->mean($data_r);
        $N = count($data_r);
        $v = 0;

        foreach($data_r as $data) {
            $v += pow($data - $mean, 2);
        }

        return sqrt(1/($N - 1) * $v);
    }

    /**
     * covariance
     *
     * Returns the covariance of two arrays. The two arrays must
     * be of equal length. Non-numeric values are treated as zeroes.
     *
     * @param array $datax_r
     * @param array $datay_r
     * @return float
     */
    public function covariance(array $datax_r, array $datay_r)
    {
        return $this->sumXY($datax_r, $datay_r) / count($datax_r) - $this->mean($datax_r) * $this->mean($datay_r);
    }

}
