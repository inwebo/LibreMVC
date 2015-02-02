<?php
registerModule();
addRoute('bookmarks/[:action]', '\\LibreMVC\\Modules\\Bookmarks\\Controllers\\BookmarksController','index');
addRoute('bookmarks/page/[:id|page]', '\\LibreMVC\\Modules\\Bookmarks\\Controllers\\BookmarksController','index');
addRoute('bookmarks/tag/[:id|tag]', '\\LibreMVC\\Modules\\Bookmarks\\Controllers\\BookmarksController','tag');
addRoute('bookmarks/tags', '\\LibreMVC\\Modules\\Bookmarks\\Controllers\\BookmarksController','tags');

/**
 * @todo Rest services routes
 */
addRoute('bookmarks/api', '\\LibreMVC\\Modules\\Bookmarks\\Controllers\\AjaxBookmarkController','index');