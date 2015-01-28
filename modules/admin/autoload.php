<?php
registerModule();
use LibreMVC\Modules\Admin as Module;
addRoute("admin/[:controller]/[:action]",'\\LibreMVC\\Modules\\Admin\\Controllers\\RoutesController','index');
