<?php
use LibreMVC\System\Hooks;
use LibreMVC\Routing\Route;
use LibreMVC\Mvc\Environnement;
use LibreMVC\Routing\RoutesCollection;

LibreMVC\AutoLoader::instance()->addPool( './' );

define('TPL_BOOKMARK_BOOKMARK', __DIR__ . '/views/tpl/bookmark.php');
define('TPL_BOOKMARK_CATEGORY', __DIR__ . '/views/tpl/category.php');

Hooks::get()->addHook( 'addDefaultSessionsVars', function (&$array) {
    $array['1']['lg']="eee";
    return $array;
});

Hooks::get()->addHook( 'addItemsToBreadCrumbs', function (&$array) {
    $array[1]->items->home = Environnement::this()->instance->baseUrl;
    //var_dump($array[1]);
});

Hooks::get()->addHook('prependRoutes', function(){
    $base_uri = trim(Environnement::this()->instance->baseUri,'/');

    $bookmarks = new Route();
    $bookmarks->name = "";
    $bookmarks->pattern = $base_uri.'/bookmark[/][:id]';
    $bookmarks->controller = '\LibreMVC\Modules\Apache\Controllers\List';
    $bookmarks->action = 'index';
    RoutesCollection::addRoute($bookmarks);

});