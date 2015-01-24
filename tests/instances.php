<?php
ini_set('display_errors', 'on');
include('../core/web/instance/autoload.php');
include('../core/http/autoload.php');
use LibreMVC\Web\Instance;
use LibreMVC\Url;

$baseDir="demo/instances/";
$default="default";

//$instance = new Instance("http://www.test.fr",$baseDir);
//var_dump($instance);
$url = "http://www.test.fr";
$url = "http://test.fr";
$factory = new Instance\InstanceFactory($url, $baseDir);
$instance = $factory->search();
var_dump($instance);
var_dump($instance->getBaseUrl());
var_dump($instance->getBaseUri());
var_dump($instance->getUri());
var_dump($instance->toUrl());