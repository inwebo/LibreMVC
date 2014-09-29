<?php

use LibreMVC\Routing\RoutesCollection;
use LibreMVC\Routing\Route;

LibreMVC\AutoLoader::instance()->addPool( './' );

$users = new Route(  '/admin/users/[:action][/]',
    '\LibreMVC\Modules\Admin\Controllers\UsersController',
    'read'
);
RoutesCollection::get( 'default' )->addRoute( $users );

/*
$routes = new Route( $base_uri . 'admin/routes/[:action][/]',
    '\LibreMVC\LibreMVC\Modules\Admin\Controllers\RoutesController',
    'read'
);
RoutesCollection::get( 'default' )->addRoute( $routes );
*/

//new \LibreMVC\Modules\Admin\Controllers\UsersController();