<?php
ini_set('display_errors', 'on');
include('../core/helpers/benchmark/class.benchmark.php');
use LibreMVC\Helpers\Benchmark;
$a = 0;

class Foo{
    public function bar(&$a) {++$a;}
}
$foo = new Foo();
$bench = new Benchmark(100, function() use ($foo, &$a) {
    $foo->bar($a);
});
var_dump($bench);