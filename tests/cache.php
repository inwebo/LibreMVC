<?php
include('../core/cache/autoload.php');
use LibreMVC\Cache;
$baseDir = "./demo/";
$cache = new Cache($baseDir,"cache.php");
$cache->start();
var_dump($cache);
echo strftime('%c');
$cache->stop();