<a href="http://www.inwebo.dev/tests/router.php/">Default route</a><br>
<a href="http://www.inwebo.dev/tests/router.php/testaction">Default route, action testaction</a><br>
<?php
ini_set('display_errors', 'on');
include('../core/routing/autoload.php');
include('../core/mvc/autoload.php');

use LibreMVC\Routing\Uri;
use LibreMVC\Routing\Route;
use LibreMVC\Routing\RoutesCollection;
use LibreMVC\Routing\Router;

// Route collection
$collection = RoutesCollection::get("default");

// Uri de base
$uri = Uri::this();
$baseUri = "/tests/router.php/";
$default = new Route($baseUri."[:action]","Default", "index");
$default->name =$baseUri."this-is-test/";
RoutesCollection::get("default")->addRoute($default);

// Default route
$router = new Router($uri,RoutesCollection::get("default"));
$routed = $router->dispatch();
$defaultRoute = assert($routed->name === $baseUri . "this-is-test/");
$assert = assert($routed->action==="testaction");
echo 'Pattern: ' . $uri->value ." === ". $default->pattern . ' is ' . (bool)$defaultRoute .'<br>';
echo 'Action ' . $routed->action ." === testaction".' is '.(bool)$assert.'<br>';

// Route inconnue
$default = new Route("pouet/","Default", "index");
RoutesCollection::get("unknown")->addRoute($default);
$routed = (new Router($uri,RoutesCollection::get("unknown")))->dispatch();
$defaultRoute = assert($routed ===false );
echo 'Pattern: ' . $uri->value ." !== ".$default->pattern . ' is ' . (bool)$defaultRoute .'<br>';

// Route collection

// Route nommées
// Route