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

    $base_uri = trim(Environnement::this()->instance->baseUri,'/');
    $defaultRoute = new \LibreMVC\Routing\Route();
    $defaultRoute->name = "";
    $defaultRoute->pattern = $base_uri.'/login-in[/]';
    $defaultRoute->controller = '\LibreMVC\Controllers\LoginController';
    $defaultRoute->action = 'index';
    RoutesCollection::addRoute($defaultRoute);

} catch (\Exception $e) {
    $message = time() . ', ' . $e->getCode() . ', ' . $e->getFile() . ', ' . $e->getLine() . ', ' . $e->getMessage() . "\n";
    //echo $message;
}
