<?php
registerModule();
addRoute('bookmarks/page/[:id|page]', '\\LibreMVC\\Modules\\Bookmarks\\Controllers\\BookmarksController','index');
addRoute('bookmarks/tag/[:id|tag]', '\\LibreMVC\\Modules\\Bookmarks\\Controllers\\BookmarksController','tag');
addRoute('bookmarks/tags', '\\LibreMVC\\Modules\\Bookmarks\\Controllers\\BookmarksController','tags');