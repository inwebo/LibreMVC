<?php
use LibreMVC\Mvc\Environnement;
use LibreMVC\Routing\RoutesCollection;
use LibreMVC\Routing\Route;

try {
    LibreMVC\AutoLoader::instance()->addPool( './' );
/*
    //@todo hooks devraient être une fonction globale
    \LibreMVC\System\Hooks::get()->addHook('loadTheme', function( &$args ){
        $args[1]->current = "default";
    });

    \LibreMVC\System\Hooks::get()->addHook( 'addItemsToBreadCrumbs', function (&$array) {
        $array[1]->items->home = Environnement::this()->instance->baseUrl;
        $array = $array[1];
    });
*/
    $baseUri = trim(Environnement::this()->instance->baseUri,'/');
    if( $baseUri !== '') {
        $base_uri = '/'.$baseUri.'/';
    }
	else {
		$base_uri = '/';
	}

    $base_uri = "/libremvc/";
    $defaultRoute = new Route( $base_uri.'[:action][/]',
    	'\LibreMVC\Mvc\Controller\AuthPageController',
        'index'
    );

    //var_dump( $defaultRoute );

    RoutesCollection::get('default')->addRoute($defaultRoute);


} catch (\Exception $e) {
    $message = time() . ', ' . $e->getCode() . ', ' . $e->getFile() . ', ' . $e->getLine() . ', ' . $e->getMessage() . "\n";
    //echo $message;
}
