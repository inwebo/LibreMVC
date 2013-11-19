<?php
use LibreMVC\System\Hooks;
use LibreMVC\Mvc\Environnement;
try {
    LibreMVC\AutoLoader::instance()->addPool( './' );

    //@todo hooks devraient être une fonction globale
    \LibreMVC\System\Hooks::get()->addHook('loadTheme', function( &$args ){
        $args[1]->current = "default";
    });

    Hooks::get()->addHook( 'addItemsToBreadCrumbs', function (&$array) {
        $array[1]->items->home = Environnement::this()->instance->baseUrl;
        $array = $array[1];
    });

} catch (\Exception $e) {
    $message = time() . ', ' . $e->getCode() . ', ' . $e->getFile() . ', ' . $e->getLine() . ', ' . $e->getMessage() . "\n";
    //echo $message;
}
