<?php
    registerModule();
    addRoute('[:action]', '\\LibreMVC\\Modules\\Bookmarks\\Controllers\\BookmarksController', 'index');
    addRoute('page/[:id|page]', '\\LibreMVC\\Modules\\Bookmarks\\Controllers\\BookmarksController', 'index');
    addRoute('tag/[:id|tag]', '\\LibreMVC\\Modules\\Bookmarks\\Controllers\\BookmarksController', 'tag');
    addRoute('search/[:id|tag]', '\\LibreMVC\\Modules\\Bookmarks\\Controllers\\BookmarksController', 'tag');
    addRoute('tags/', '\\LibreMVC\\Modules\\Bookmarks\\Controllers\\BookmarksController', 'tags');

    // Propose le bookmarklet à un utilisateur enregistré
    addRoute('bookmarklet/', '\\LibreMVC\\Modules\\Bookmarks\\Controllers\\WidgetController', 'bookmarklet');

    // Affiche le formulaire de manipulation des bookmarks && Controller ajax
    addRoute('form/[:id|bookmarkId]', '\\LibreMVC\\Modules\\Bookmarks\\Controllers\\AjaxBookmarkController', 'index');