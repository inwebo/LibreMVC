<?php

use LibreMVC\Routing\RoutesCollection;
use LibreMVC\Routing\Route;

try {
    $base_uri = getInstanceBaseUri();

    LibreMVC\AutoLoader::instance()->addPool( './' );

    define('TPL_BOOKMARK_BOOKMARK', __DIR__ . '/views/tpl/bookmark.php');
    define('TPL_BOOKMARKS_WIDGET', __DIR__ . '/assets/js/widget.js');
    define('TPL_BOOKMARKS_FORM', __DIR__ . '/views/tpl/form.php');

    // API
    $bookmarks = new Route($base_uri.'api/bookmark/');
    $bookmarks->controller = '\LibreMVC\Modules\Bookmarks\Controllers\BookmarkController';
    $bookmarks->action = 'index';
    RoutesCollection::get('default')->addRoute($bookmarks);

    $bookmarks = new Route($base_uri.'api/bookmark/form');
    $bookmarks->controller = '\LibreMVC\Modules\Bookmarks\Controllers\BookmarkController';
    $bookmarks->action = 'form';
    RoutesCollection::get('default')->addRoute($bookmarks);

} catch (\Exception $e) {
    $message = time() . ', ' . $e->getCode() . ', ' . $e->getFile() . ', ' . $e->getLine() . ', ' . $e->getMessage() . "\n";
    var_dump($e);
}

