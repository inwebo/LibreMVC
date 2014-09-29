<?php
use LibreMVC\Routing\RoutesCollection;
use LibreMVC\Routing\Route;

try {
    LibreMVC\AutoLoader::instance()->addPool( './' );

    $base_uri = getInstanceBaseUri();

    // FILO routes
    // Une route statique n'a pas besoin d'action du controller StaticController, voir __call
    /*
    $staticRoute = new Route( $base_uri . '[:static][/]',
        '\LibreMVC\Controllers\StaticController'
    );
    RoutesCollection::get( 'default' )->addRoute( $staticRoute );
    */

    $defaultRoute = new Route( $base_uri . '[:action][/]',
    	'\LibreMVC\Controllers\HomeController',
        'index'
    );
    RoutesCollection::get( 'default' )->addRoute( $defaultRoute );

    $login = new Route( $base_uri . 'log-in',
        '\LibreMVC\Controllers\LoginController',
        'login'
    );
    RoutesCollection::get( 'default' )->addRoute( $login );

    $logout = new Route( $base_uri . 'log-out',
        '\LibreMVC\Controllers\LoginController',
        'logout'
    );
    RoutesCollection::get( 'default' )->addRoute( $logout );

    $logout = new Route( $base_uri . 'page/[:static][/]',
        '\LibreMVC\Mvc\Controller\StaticController',
        'index'
    );
    RoutesCollection::get( 'default' )->addRoute( $logout );

} catch (\Exception $e) {
    var_dump($e);
}
