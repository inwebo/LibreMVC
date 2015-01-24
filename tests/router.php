<?php
ini_set('display_errors', 'on');
include('../core/routing/autoload.php');

use LibreMVC\Routing\Uri;
use LibreMVC\Routing\Route;

class Controller {

    public function index(){
        echo "foo";
    }

}
$baseUri = "/libre/";
$pattern = $baseUri."f/f/f[/]";
$route = new Route($pattern);
$route->name = "/libre/foo/bar/";
$route->controller = "Controller";
$route->action = "index";

$uri = Uri::this();

$routeCollection = \LibreMVC\Routing\RoutesCollection::get("default");
$routeCollection->addRoute($route);

var_dump($uri->value);
var_dump($pattern);

//var_dump(assert($uri->value === $pattern));
//var_dump($route);
//var_dump($route->toArray());

//var_dump($routeCollection);

$router = new \LibreMVC\Routing\Router($uri, $routeCollection,'\\LibreMVC\\Routing\\UriParser\\RouteConstraint');
$router->dispatch();