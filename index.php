<?php
//include("autoload.php");

include('core/helpers/benchmark/class.benchmark.php');
use LibreMVC\Helpers\Benchmark;

static $i = 0;
$a = new Benchmark( 1, function() {

    new StdClass;
});

echo $a->getElapsedTime() . '<br>';
//echo $a->getMemoryUsage(). '<br>';
//$a = microtime();
//echo $a . '<br>';
//usleep(10);
//$b =microtime();
//echo $b. '<br>';
//echo floatval($b) - floatval($a). '<br>';
