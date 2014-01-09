<?php
use LibreMVC\Mvc\Environnement;
use LibreMVC\Routing\RoutesCollection;
try {
    LibreMVC\AutoLoader::instance()->addPool( './' );

    //@todo hooks devraient être une fonction globale
    \LibreMVC\System\Hooks::get()->addHook('loadTheme', function( &$args ){
        $args[1]->current = "default";
    });

    \LibreMVC\System\Hooks::get()->addHook( 'addItemsToBreadCrumbs', function (&$array) {
        $array[1]->items->home = Environnement::this()->instance->baseUrl;
        $array = $array[1];
    });

    $baseUri = trim(Environnement::this()->instance->baseUri,'/');

    if( $baseUri !== '') {
        $base_uri = '/'.$baseUri.'/';
    }
	else {
		$base_uri = '/';
	}

    $defaultRoute = new \LibreMVC\Routing\Route( $base_uri.'[:action][/]',
    	'\LibreMVC\Controllers\HomeController',
        'index'
    );
    RoutesCollection::get('default')->addRoute($defaultRoute);



    //$base_uri = trim(Environnement::this()->instance->baseUri,'/');
    $defaultRoute = new \LibreMVC\Routing\Route($base_uri.'restservice[/]');
    $defaultRoute->controller = '\LibreMVC\Controllers\RestServiceController';
    $defaultRoute->action = 'index';
    RoutesCollection::get('default')->addRoute($defaultRoute);

    $defaultRoute = new \LibreMVC\Routing\Route($base_uri.'login-in[/]');
    $defaultRoute->controller = '\LibreMVC\Controllers\LoginController';
    $defaultRoute->action = 'index';
    RoutesCollection::get('default')->addRoute($defaultRoute);

    $defaultRoute = new \LibreMVC\Routing\Route($base_uri.'login-out[/]');
    $defaultRoute->controller = '\LibreMVC\Controllers\LoginController';
    $defaultRoute->action = 'logout';
    RoutesCollection::get('default')->addRoute($defaultRoute);

} catch (\Exception $e) {
    $message = time() . ', ' . $e->getCode() . ', ' . $e->getFile() . ', ' . $e->getLine() . ', ' . $e->getMessage() . "\n";
    //echo $message;
}
