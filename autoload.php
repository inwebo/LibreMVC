<?php
include("core/autoloader/class.autoloader.php");

try {
    spl_autoload_register( "\\LibreMVC\\AutoLoader::handler" );
    \LibreMVC\Autoloader::addPool("core/");

    $uri = new \LibreMCV\Http\Uri($_SERVER['REQUEST_URI']);
    echo '<h2>URI</h2>';
    echo '<h3>Object</h3>';
    var_dump($uri);
    echo '<h3>As array</h3>';
    var_dump($uri->toArray());

    $restRoute = new LibreMCV\Routing\Route();
    $restRoute->name = "/Routing/Yeah";
    $restRoute->pattern = '/Routing/test[/][:controller][/][:id|Page][/][:action][/][:id][/]';
    \LibreMCV\Routing\RoutesCollection::addRoute($restRoute);

    $deepRoute = new LibreMCV\Routing\Route();
    $deepRoute->name = "";
    $deepRoute->pattern = '/Routing/deep/tree/route[/][:action][/][:id|Page][/]';
    \LibreMCV\Routing\RoutesCollection::addRoute($deepRoute);


// Est atteint lorsque acune route nommée ou aucun pattern correspond
// Devrait ettre le gestionnaire d'erreur
    $route = new LibreMCV\Routing\Route();
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
    // Boot tache if cli
    if(php_sapi_name() == 'cli') {
        echo 'Yeah';
    }


} catch (\Exception $e) {
    $message = time() . ',' . $e->getCode() . ',' . $e->getFile() . ',' . $e->getLine() . ',' . $e->getMessage() . "\n";
    echo $message;
}
