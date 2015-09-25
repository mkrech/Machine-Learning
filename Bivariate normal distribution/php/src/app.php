<?php
$time_start = microtime(true);

require_once('BivariateNormalDistribution.php');
require_once('NormalDistribution.php');

//Human weight and height
$datax = [167, 170, 160, 152, 157, 160];
$datay = [60, 64, 57, 46, 55, 50];


$bnvnd = new \mkrech\Distribution\BivariateNormalDistribution();

$bnvnd->init($datax, $datay);

$oldResult = 0;
$i = 0;
for ($x = 100; $x < 2000; $x++) {
    for ($y = 0; $y < 1000; $y++) {
        $result = $bnvnd->compute($x, $y);

        if ($result > $oldResult) {
            $oldResult = $result;
            echo('Bivariate: x=' . $x . ' y=' . $y . ' ' . $result . PHP_EOL);
        }
        $i++;
    }
}
echo($oldResult . PHP_EOL);

$time_end = microtime(true);
$time = $time_end - $time_start;

echo "In $time Sekunden \n" . $i;
