<?php
namespace LibreMVC\Modules\Bookmarks  {
    registerModule();
    addRoute('/[:action]', '\\LibreMVC\\Modules\\Bookmarks\\Controllers\\BookmarksController', 'index');
    addRoute('page/[:id|page]', '\\LibreMVC\\Modules\\Bookmarks\\Controllers\\BookmarksController', 'index');
    addRoute('tag/[:id|tag]', '\\LibreMVC\\Modules\\Bookmarks\\Controllers\\BookmarksController', 'tag');
    addRoute('tags', '\\LibreMVC\\Modules\\Bookmarks\\Controllers\\BookmarksController', 'tags');
    addRoute('api/public[/][:action]', '\\LibreMVC\\Modules\\Bookmarks\\Controllers\\AjaxBookmarkController', 'index');
    addRoute('api/private', '\\LibreMVC\\MVC\\Controller\\AjaxController\\PrivateAjaxController', 'index');
    addRoute('api/rest', '\\LibreMVC\\MVC\\Controller\\AjaxController\\PrivateAjaxController\\RestController', 'index');
}
// Une route pour le formulaire, ajax privé

// Une route pour ajouter un bookmark, rest privé
