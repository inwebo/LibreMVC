<?php
use LibreMVC\System\Hooks;
use LibreMVC\Routing\Route;
use LibreMVC\Mvc\Environnement;
use LibreMVC\Routing\RoutesCollection;

LibreMVC\AutoLoader::instance()->addPool( './' );

define('TPL_BOOKMARK', __DIR__ . '/views/tpl/bookmark.php');


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
    $bookmarks->pattern = $base_uri.'/bookmarks[/][:id|(int)page][/]';
    $bookmarks->controller = '\LibreMVC\Modules\Bookmarks\Controllers\BookmarksController';
    $bookmarks->action = 'index';
    RoutesCollection::addRoute($bookmarks);

});