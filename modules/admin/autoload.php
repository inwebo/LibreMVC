<?php
registerModule();
addRoute("admin[/][:action]",'\\LibreMVC\\Modules\\Admin\\Controllers\\HomeController','index');
addRoute("admin/users/[:action]",'\\LibreMVC\\Modules\\Admin\\Controllers\\UsersController','index');
