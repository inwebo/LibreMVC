<?php
include('../core/exception/class.exception.php');
include('../core/cache/autoload.php');
use LibreMVC\Cache;
$baseDir = "./demo/";
try {
    $cache = new Cache($baseDir,"cache.php");
    $cache->start();
    var_dump($cache);
    echo strftime('%c');
    $cache->stop();
}
catch (\Exception $e) {
    var_dump($e);
}
