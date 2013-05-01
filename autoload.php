<?php
include("core/autoloader/class.autoloader.php");

try {
    spl_autoload_register( "\\LibreMVC\\AutoLoader::handler" );

    new \LibreMVC\System\Boot('\LibreMVC\System\Boot\Steps');

    $restRoute = new LibreMCV\Routing\Route();
    $restRoute->name = "";
    $restRoute->pattern = 'LibreMVC[/][:action][/][:id][/]';
    \LibreMCV\Routing\RoutesCollection::addRoute($restRoute);

    $router = new \LibreMCV\Routing\Router( \LibreMCV\Http\Uri::current(), \LibreMCV\Routing\RoutesCollection::getRoutes(), \LibreMCV\Routing\UriParser\Asserts::load() );
    $routedRoute = $router->dispatch();

    var_dump($routedRoute);


    \LibreMCV\Mvc::invoker( 'LibreMCV\Controllers\HomeController', $processedRoute->action, $processedRoute->params);



} catch (\Exception $e) {
    $message = time() . ',' . $e->getCode() . ',' . $e->getFile() . ',' . $e->getLine() . ',' . $e->getMessage() . "\n";
    echo $message;
}
/*
if(php_sapi_name() == 'cli') {
    echo 'Yeah';
}*/
