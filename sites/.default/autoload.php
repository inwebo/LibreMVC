<?php
use LibreMVC\Routing\RoutesCollection;
use LibreMVC\Routing\Route;

try {
    LibreMVC\AutoLoader::instance()->addPool( './' );

    $base_uri = getInstanceBaseUri();

    // FILO routes
    $defaultRoute = new Route( $base_uri . '[:action][/]',
        '\LibreMVC\Controllers\HomeController',
        'index'
    );
    RoutesCollection::get( 'default' )->addRoute( $defaultRoute );


} catch (\Exception $e) {
    var_dump($e);
}