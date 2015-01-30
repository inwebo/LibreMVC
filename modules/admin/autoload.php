<?php
registerModule();
use LibreMVC\Modules\Admin as Module;
addRoute("admin[/][:action]",'\\LibreMVC\\Modules\\Admin\\Controllers\\HomeController','index');
