<?php
use LibreMVC\Mvc\Environnement;
use LibreMVC\Routing\RoutesCollection;
use LibreMVC\Routing\Route;

try {
    LibreMVC\AutoLoader::instance()->addPool( './' );

    $base_uri = instanceBaseUri();

    // FILO routes
    $defaultRoute = new Route( $base_uri.'[:action][/]',
    	'\LibreMVC\Controllers\HomeController',
        'index'
    );
    RoutesCollection::get('default')->addRoute($defaultRoute);

    $testAjax = new Route( $base_uri.'rest[/]',
        '\LibreMVC\Modules\Bookmarks\Controllers\BookmarkController',
        'index'
    );
    RoutesCollection::get('default')->addRoute($testAjax);

    $auth = new Route( $base_uri.'auth[/]',
        '\LibreMVC\Mvc\Controller\AuthPageController',
        'index'
    );
    RoutesCollection::get('default')->addRoute($auth);

    $rest = new Route( $base_uri.'rest/[:id|((regex)idTest#^([0-9])+$#]',
        '\LibreMVC\Mvc\Controller\RestController',
        'index'
    );
    RoutesCollection::get('default')->addRoute($rest);

    $login = new Route( $base_uri.'log-in',
        '\LibreMVC\Controllers\LoginController',
        'login'
    );
    RoutesCollection::get('default')->addRoute($login);

    $logout = new Route( $base_uri.'log-out',
        '\LibreMVC\Controllers\LoginController',
        'logout'
    );
    RoutesCollection::get('default')->addRoute($logout);
    $bookmarks = new Route($base_uri.'bookmarks[/][:id|(regex)page#^([0-9])+$#]');
    $bookmarks->controller = '\LibreMVC\Modules\Bookmarks\Controllers\BookmarksController';
    $bookmarks->action = 'index';

    RoutesCollection::get('default')->addRoute($bookmarks);
    $bookmarks = new Route($base_uri.'bookmarks/tags/');
    $bookmarks->controller = '\LibreMVC\Modules\Bookmarks\Controllers\BookmarksController';
    $bookmarks->action = 'tags';
    RoutesCollection::get('default')->addRoute($bookmarks);

    RoutesCollection::get('default')->addRoute($bookmarks);
    $bookmarks = new Route($base_uri.'bookmarks/tag/[:id|tag][/]');
    $bookmarks->controller = '\LibreMVC\Modules\Bookmarks\Controllers\BookmarksController';
    $bookmarks->action = 'tag';
    RoutesCollection::get('default')->addRoute($bookmarks);






    //var_dump( $defaultRoute );

} catch (\Exception $e) {
    $message = time() . ', ' . $e->getCode() . ', ' . $e->getFile() . ', ' . $e->getLine() . ', ' . $e->getMessage() . "\n";
    //echo $message;
}
