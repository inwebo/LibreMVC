<?php
include("core/autoloader/class.autoloader.php");
// #debug# echo 'l ' . __LINE__ . ' : ' . __FILE__ . '<br>';
try {
    spl_autoload_register( "\\LibreMVC\\AutoLoader::handler" );
    \LibreMVC\Autoloader::addPool("./");
    \LibreMVC\Autoloader::addPool("./core/");

    // Default route
    $defaultRoute = new \LibreMCV\Routing\Route();
    $defaultRoute->name = "";
    $defaultRoute->pattern = \LibreMVC\Http\Context::getBaseDir( __FILE__, false ) . '[/][:action][/][:id][/]';
    $defaultRoute->controller = '\LibreMCV\Controllers\HomeController';
    $defaultRoute->action = 'index';
    \LibreMCV\Routing\RoutesCollection::addRoute($defaultRoute);


    new LibreMCV\System\Boot( new \LibreMVC\System\Boot\Steps() );

} catch (\Exception $e) {
    $message = time() . ',' . $e->getCode() . ',' . $e->getFile() . ',' . $e->getLine() . ',' . $e->getMessage() . "\n";
    echo $message;
}
/*
if(php_sapi_name() == 'cli') {
    echo 'Yeah';
}*/
