<?php
namespace LibreMVC\Modules\Bookmarks  {
    use LibreMVC\Database\Driver\MySql;
    use LibreMVC\Files\Config;
    use LibreMVC\System;
    use LibreMVC\Database\Drivers;


    registerModule();
    addRoute('[:action]', '\\LibreMVC\\Modules\\Bookmarks\\Controllers\\BookmarksController', 'index');
    addRoute('page/[:id|page]', '\\LibreMVC\\Modules\\Bookmarks\\Controllers\\BookmarksController', 'index');
    addRoute('tag/[:id|tag]', '\\LibreMVC\\Modules\\Bookmarks\\Controllers\\BookmarksController', 'tag');
    addRoute('search/[:id|tag]', '\\LibreMVC\\Modules\\Bookmarks\\Controllers\\BookmarksController', 'tag');
    addRoute('tags/', '\\LibreMVC\\Modules\\Bookmarks\\Controllers\\BookmarksController', 'tags');
    // Propose le bookmarklet à un utilisateur enregistré
    addRoute('bookmarklet/', '\\LibreMVC\\Modules\\Bookmarks\\Controllers\\WidgetController', 'index');
    // Affiche le formulaire de manipulation des bookmarks
    addRoute('api/bookmark', '\\LibreMVC\\Modules\\Bookmarks\\Controllers\\AjaxBookmarkController', 'index');
    // Router des requêtes ajax
    //addRoute('api/bookmark/do/', '\\LibreMVC\\Modules\\Bookmarks\\Controllers\\AjaxBookmarkController', 'index');

    $config = Config::load(System::this()->getModule('bookmarks')->getConfig("dir"));
    Drivers::add('bookmarks',new MySql(
        $config->Bookmarks['server'],
        $config->Bookmarks['database'],
        $config->Bookmarks['user'],
        $config->Bookmarks['password']
    ));
    /*
    addRoute('api/public[/][:action]', '\\LibreMVC\\Modules\\Bookmarks\\Controllers\\AjaxBookmarkController', 'index');
    addRoute('api/private', '\\LibreMVC\\MVC\\Controller\\AjaxController\\PrivateAjaxController', 'index');
    addRoute('api/rest', '\\LibreMVC\\MVC\\Controller\\AjaxController\\PrivateAjaxController\\RestController', 'index');
    */
}
// Une route pour le formulaire, ajax privé

// Une route pour ajouter un bookmark, rest privé
