<?php
include( dirname(__FILE__) . "/core/autoloader/class.autoloader.php" );
use LibreMVC\Mvc\Environnement;
try {
    LibreMVC\AutoLoader::instance()->addPool( './core/' );
    spl_autoload_register( "\\LibreMVC\\AutoLoader::handler" );

    define('CSV', ';');

    $defaultRoute = new \LibreMVC\Routing\Route();
    $defaultRoute->name = "";
    $defaultRoute->pattern = \LibreMVC\Http\Context::getBaseDir( __FILE__, false ) . '/bookmark/';
    $defaultRoute->controller = '\LibreMVC\Controllers\BookmarkController';
    $defaultRoute->action = 'index';
    \LibreMVC\Routing\RoutesCollection::addRoute($defaultRoute);

    $bookmarks = new \LibreMVC\Routing\Route();
    $bookmarks->name = "";
    $bookmarks->pattern = \LibreMVC\Http\Context::getBaseDir( __FILE__, false ) . '/bookmarks/category[/][:id|idCategorie][/][page][/][:id|Page]';
    $bookmarks->controller = '\LibreMVC\Controllers\BookmarksController';
    $bookmarks->action = 'category';
    \LibreMVC\Routing\RoutesCollection::addRoute($bookmarks);

    $bookmarks = new \LibreMVC\Routing\Route();
    $bookmarks->name = "";
    $bookmarks->pattern = \LibreMVC\Http\Context::getBaseDir( __FILE__, false ) . '/bookmarks[/][:id|page][/]';
    $bookmarks->controller = '\LibreMVC\Controllers\BookmarksController';
    $bookmarks->action = 'index';
    \LibreMVC\Routing\RoutesCollection::addRoute($bookmarks);

    // Default route


    // Default route
    $defaultRoute = new \LibreMVC\Routing\Route();
    $defaultRoute->name = "";
    $defaultRoute->pattern = \LibreMVC\Http\Context::getBaseDir( __FILE__, false ) . '[/][:action][/][:id][/]';
    $defaultRoute->controller = '\LibreMVC\Controllers\HomeController';
    $defaultRoute->action = 'index';
    \LibreMVC\Routing\RoutesCollection::addRoute($defaultRoute);



    new LibreMVC\System\Boot( new \LibreMVC\System\Boot\Steps() );

    var_dump(LibreMVC\Mvc\Environnement::this());
} catch (\Exception $e) {
    $message = time() . ',' . $e->getCode() . ',' . $e->getFile() . ',' . $e->getLine() . ',' . $e->getMessage() . "\n";
    echo $message;
}
/*
if(php_sapi_name() == 'cli') {
    echo 'Yeah';
}*/
