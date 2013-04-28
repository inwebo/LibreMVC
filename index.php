<?php

include("autoload.php");


//$restRoute = new \LibreMCV\Routing\Route();
/*
$restRoute->name = "/Routing/Yeah";
$restRoute->pattern = '/Routing/test[/][:controller][/][:id|Page][/][:action][/][:id][/]';
\LibreMCV\Routing\RoutesCollection::addRoute($restRoute);

$deepRoute = new \LibreMCV\Routing\Route();
$deepRoute->name = "";
$deepRoute->pattern = '/Routing/deep/tree/route[/][:action][/][:id|Page][/]';
\LibreMCV\Routing\RoutesCollection::addRoute($deepRoute);


// Est atteint lorsque acune route nommée ou aucun pattern correspond
// Devrait ettre le gestionnaire d'erreur
$route = new \LibreMCV\Routing\Route();
$route->pattern = '[/]';
$route->controller = "Error";
$route->action = "Http404";
\LibreMCV\Routing\RoutesCollection::addRoute($route);



echo '<h2>Route</h2>';
echo ('Mandatory segment : '. $restRoute->extractMandatorySegment()) . "<br>";
echo ('Pattern : '. $restRoute->pattern . "<br>");
echo '<h3>As array</h3>';
var_dump($restRoute->patternToArray());
echo '<h3>Mandatory As array</h3>';
var_dump($restRoute->mandatoryToArray());

echo '<h2>Router</h2>';
$router = new \LibreMCV\Routing\Router($uri, \LibreMCV\Routing\RoutesCollection::getRoutes(), \LibreMCV\Routing\UriParser\Asserts::load() );
var_dump($router);
echo '<h3>Processed route</h3>';
$processedRoute = $router->route();
var_dump($processedRoute);
*/