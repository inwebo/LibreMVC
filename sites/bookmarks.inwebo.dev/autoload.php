<?php
use LibreMVC\Mvc\Environnement;
use LibreMVC\Routing\RoutesCollection;
use LibreMVC\Routing\Route;

try {
    LibreMVC\AutoLoader::instance()->addPool( './' );

    $base_uri = getInstanceBaseUri();

    // FILO routes
    $defaultRoute = new Route( $base_uri.'[:action][/]',
        '\LibreMVC\Modules\Bookmarks\Controllers\BookmarksController',
        'index'
    );
    RoutesCollection::get('default')->addRoute($defaultRoute);

    $bookmarks = new Route($base_uri.'page/[:id|(regex)page#^([0-9])+$#]');
    $bookmarks->controller = '\LibreMVC\Modules\Bookmarks\Controllers\BookmarksController';
    $bookmarks->action = 'index';
    RoutesCollection::get('default')->addRoute($bookmarks);

    $bookmarks = new Route($base_uri.'tags/');
    $bookmarks->controller = '\LibreMVC\Modules\Bookmarks\Controllers\BookmarksController';
    $bookmarks->action = 'tags';
    RoutesCollection::get('default')->addRoute($bookmarks);

    $bookmarks = new Route($base_uri.'tag/[:id|tag][/]');
    $bookmarks->controller = '\LibreMVC\Modules\Bookmarks\Controllers\BookmarksController';
    $bookmarks->action = 'tag';
    RoutesCollection::get('default')->addRoute($bookmarks);

} catch (\Exception $e) {
    $message = time() . ', ' . $e->getCode() . ', ' . $e->getFile() . ', ' . $e->getLine() . ', ' . $e->getMessage() . "\n";
    var_dump($e);
}
