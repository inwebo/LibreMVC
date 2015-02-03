<?php
registerModule();
addRoute('bookmarks/[:action]', '\\LibreMVC\\Modules\\Bookmarks\\Controllers\\BookmarksController','index');
addRoute('bookmarks/page/[:id|page]', '\\LibreMVC\\Modules\\Bookmarks\\Controllers\\BookmarksController','index');
addRoute('bookmarks/tag/[:id|tag]', '\\LibreMVC\\Modules\\Bookmarks\\Controllers\\BookmarksController','tag');
addRoute('bookmarks/tags', '\\LibreMVC\\Modules\\Bookmarks\\Controllers\\BookmarksController','tags');
addRoute('bookmarks/api/public', '\\LibreMVC\\Modules\\Bookmarks\\Controllers\\AjaxBookmarkController','index');
addRoute('bookmarks/api/private', '\\LibreMVC\\MVC\\Controller\\AjaxController\\PrivateAjaxController','index');
addRoute('bookmarks/api/rest', '\\LibreMVC\\MVC\\Controller\\AjaxController\\PrivateAjaxController\\RestController','index');