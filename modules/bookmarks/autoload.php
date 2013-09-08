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
    $bookmarks->pattern = $base_uri . '/bookmarks/category[/][:id|(regex)idCategorie#^([0-9])+$#][/][page][/][:id|(regex)page#^([0-9])+$#]';
    $bookmarks->controller = '\LibreMVC\Modules\Bookmarks\Controllers\BookmarksController';
    $bookmarks->action = 'category';
    RoutesCollection::addRoute($bookmarks);

    $bookmarks = new Route();
    $bookmarks->name = "";
    $bookmarks->pattern = $base_uri . '/bookmarks/tag[/][:id|tag]';
    $bookmarks->controller = '\LibreMVC\Modules\Bookmarks\Controllers\BookmarksController';
    $bookmarks->action = 'tag';
    RoutesCollection::addRoute($bookmarks);

    $bookmarks = new Route();
    $bookmarks->name = "";
    $bookmarks->pattern = $base_uri . '/bookmarks/tags[/]';
    $bookmarks->controller = '\LibreMVC\Modules\Bookmarks\Controllers\BookmarksController';
    $bookmarks->action = 'tags';
    RoutesCollection::addRoute($bookmarks);

    $bookmarks = new Route();
    $bookmarks->name = "";
    $bookmarks->pattern = $base_uri.'/bookmarks[/][:id|(int)page][/]';
    $bookmarks->controller = '\LibreMVC\Modules\Bookmarks\Controllers\BookmarksController';
    $bookmarks->action = 'index';
    RoutesCollection::addRoute($bookmarks);

    $bookmarks = new Route();
    $bookmarks->name = "";
    $bookmarks->pattern = $base_uri.'/bookmark[/][:id]';
    $bookmarks->controller = '\LibreMVC\Modules\Bookmarks\Controllers\BookmarkController';
    $bookmarks->action = 'index';
    RoutesCollection::addRoute($bookmarks);

});