<?php
// New cache
include('../core/cache/class.cache.php');
// Old cache
include('demo/class.cache.php');

// Benchmark
include('../core/helpers/benchmark/class.benchmark.php');



use LibreMVC\Cache as NewCache;
use Cache as OldCache;
use LibreMVC\Helpers\Benchmark;

$bench = new Benchmark(1000, function() {
    $baseDir = "./demo/";
    $cache = new NewCache($baseDir,"new_cache.php");
    $cache->start();
    echo strftime('%c');
    $cache->stop();
});
var_dump($bench);

$bench = new Benchmark(1000, function() {
    $baseDir = "./demo/";
    $cache = new OldCache($baseDir,"old_cache.php");
    $cache->start();
    echo strftime('%c');
    $cache->stop();
});
var_dump($bench);




