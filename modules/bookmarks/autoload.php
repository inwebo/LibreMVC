<?php
use LibreMVC\System\Hooks;
use LibreMVC\Routing\Route;
use LibreMVC\Mvc\Environnement;
use LibreMVC\Routing\RoutesCollection;

LibreMVC\AutoLoader::instance()->addPool( './' );

define('TPL_BOOKMARK_BOOKMARK', __DIR__ . '/views/tpl/bookmark.php');
define('TPL_BOOKMARK_CATEGORY', __DIR__ . '/views/tpl/category.php');

//define('MODULE_BOOKMARK_DB_TABLE_PREFFIX', __DIR__ . '/views/tpl/category.php');

Hooks::get()->addHook( 'addDefaultSessionsVars', function (&$array) {
    $array['1']['lg']="FR";
    return $array;
});


Hooks::get()->addHook('prependRoutes', function(){
    $base_uri = '/'.trim(Environnement::this()->instance->baseUri,'/');


    //$bookmarks = new Route($base_uri . '/category[/][:id|(regex)idCategorie#^([0-9])+$#][/][page][/][:id|(regex)page#^([0-9])+$#]');
    $bookmarks = new Route($base_uri . 'category[/][:id|(regex)idCategorie#^([0-9])+$#][/][page][/][:id|(regex)page#^([0-9])+$#]');
    $bookmarks->controller = '\LibreMVC\Modules\Bookmarks\Controllers\BookmarksController';
    $bookmarks->action = 'category';
    RoutesCollection::get('default')->addRoute($bookmarks);

    $bookmarks = new Route($base_uri . '/tag[/][:id|tag]');
    $bookmarks->controller = '\LibreMVC\Modules\Bookmarks\Controllers\BookmarksController';
    $bookmarks->action = 'tag';
    RoutesCollection::get('default')->addRoute($bookmarks);

    $bookmarks = new Route($base_uri . '/tags[/]');
    $bookmarks->controller = '\LibreMVC\Modules\Bookmarks\Controllers\BookmarksController';
    $bookmarks->action = 'tags';
    RoutesCollection::get('default')->addRoute($bookmarks);

    $bookmarks = new Route($base_uri . '/form[/]');
    $bookmarks->controller = '\LibreMVC\Modules\Bookmarks\Controllers\BookmarksController';
    $bookmarks->action = 'form';
    RoutesCollection::get('default')->addRoute($bookmarks);

    $bookmarks = new Route($base_uri . '/widget[/]');
    $bookmarks->controller = '\LibreMVC\Modules\Bookmarks\Controllers\BookmarksController';
    $bookmarks->action = 'widget';
    RoutesCollection::get('default')->addRoute($bookmarks);

    $bookmarks = new Route($base_uri . '/login[/]');
    $bookmarks->controller = '\LibreMVC\Modules\Bookmarks\Controllers\BookmarksController';
    $bookmarks->action = 'login';
    RoutesCollection::get('default')->addRoute($bookmarks);

    $bookmarks = new Route($base_uri.'/bookmark[/][:id]');
    $bookmarks->controller = '\LibreMVC\Modules\Bookmarks\Controllers\BookmarkController';
    $bookmarks->action = 'index';
    RoutesCollection::get('default')->addRoute($bookmarks);

});