<?php
include("core/autoloader/class.autoloader.php");

try {
    spl_autoload_register( "\\LibreMVC\\AutoLoader::handler" );
    // Core
    \LibreMVC\Autoloader::addPool("./core/");
    // Modules
    \LibreMVC\Autoloader::addPool("./");
    \LibreMVC\Autoloader::addPool("sites/_default");
    set_error_handler('\\LibreMVC\Errors\\ErrorsHandler::add');

    $uri = new \LibreMCV\Http\Uri($_SERVER['REQUEST_URI']);
    $instance = new \LibreMVC\Instance( \LibreMVC\Http\Context::getUrl() );
    $paths = $instance->processPattern( \LibreMVC\Files\Config::load("config/paths.ini"),"home",'index' );

    var_dump($instance);
    var_dump($paths);

    // Route par defaut

    $restRoute = new LibreMCV\Routing\Route();
    $restRoute->name = "";
    $restRoute->pattern = trim(dirname($_SERVER["PHP_SELF"]),'/').'[/][:controller][/][:action][/][:id][/]';
    \LibreMCV\Routing\RoutesCollection::addRoute($restRoute);

    // Router
    $router = new \LibreMCV\Routing\Router($uri, \LibreMCV\Routing\RoutesCollection::getRoutes(), \LibreMCV\Routing\UriParser\Asserts::load() );
    $processedRoute = $router->route();
    var_dump($processedRoute);

    // Routes systemes
    \LibreMVC\Database\Driver::setup(
        "route",
        new \LibreMVC\Database\Driver\SQlite($paths['base_routes'])
    );

    \LibreMVC\AutoLoader::getAutoload($paths['base_autoload']);

} catch (\Exception $e) {
    $message = time() . ',' . $e->getCode() . ',' . $e->getFile() . ',' . $e->getLine() . ',' . $e->getMessage() . "\n";
    echo $message;
}
/*
if(php_sapi_name() == 'cli') {
    echo 'Yeah';
}*/
