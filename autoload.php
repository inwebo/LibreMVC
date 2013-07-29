<?php
include("core/autoloader/class.autoloader.php");

try {
    LibreMVC\AutoLoader::instance()->addPool( './core/' );
    spl_autoload_register( "\\LibreMVC\\AutoLoader::handler" );

    // Bookmarks route
    $bookmarks = new \LibreMCV\Routing\Route();
    $bookmarks->name = "";
    $bookmarks->pattern = \LibreMVC\Http\Context::getBaseDir( __FILE__, false ) . '/bookmarks/category[/][:id|idCategorie][/][:page][/][:id|Page]';
    $bookmarks->controller = '\LibreMCV\Controllers\BookmarksController';
    $bookmarks->action = 'category';
    \LibreMCV\Routing\RoutesCollection::addRoute($bookmarks);

    $bookmarks = new \LibreMCV\Routing\Route();
    $bookmarks->name = "";
    $bookmarks->pattern = \LibreMVC\Http\Context::getBaseDir( __FILE__, false ) . '/bookmarks[/][:id|page][/]';
    $bookmarks->controller = '\LibreMCV\Controllers\BookmarksController';
    $bookmarks->action = 'index';
    \LibreMCV\Routing\RoutesCollection::addRoute($bookmarks);


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
