<?php
ini_set('display_errors', 'on');
include('../core/files/autoload.php');
include('../core/web/instance/autoload.php');
include('../core/web/instance/pathsfactory/autoload.php');

use LibreMVC\Files\Config;

use LibreMVC\Web\Instance\PathsFactory;

$ini = 'demo/config.ini';
$ini2 = 'demo/config2.ini';
$config = Config::load($ini);
$config2 = Config::load($ini2);



use LibreMVC\Web\Instance\PathsFactory\Path;

// Theme & application mimimum
//$base = Path::processPattern($config->Pattern,$config->Tokens);
//var_dump($base);

//$appPaths = PathsFactory::processPattern(array_merge($config->Pattern, $config->Root), $config->Tokens);
//var_dump($appPaths);

$intance = (array)PathsFactory::processPattern(array_merge($config->Pattern, $config->Root, $config->Instances), $config->Tokens);
//unset($intance['sites']);
//var_dump($intance);

$path = new Path($intance, 'http://www.libre.dev/','/home/inwebo/www/demo/');

var_dump($path->getBaseUrl());
var_dump($path->getBaseDir());
//var_dump($path);
//var_dump($config);
//var_dump($config2);
/*
$node = new \LibreMVC\Files\Inode($ini);
//var_dump($node);
$node = new \LibreMVC\Files\Inode("benchmark.php");
$node->copy(".benchmark.php");*/
//var_dump($node->getMimeType());

//var_dump(PathsFactory::inject($appPaths,'http://www.google.fr/'));
//$appPaths = PathsFactory::inject($appPaths,'http://www.google.fr/');



//var_dump($path->getBaseUrl());
//var_dump($path->getBaseDir());
//var_dump($path->getBaseDir("core"));

$base = 'hello';
$ref =& $base;
$copy = $ref;

$copy = 'world';

echo $base;