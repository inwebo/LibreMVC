<?php
registerModule();
addRoute("login/",'\\LibreMVC\\Modules\\Login\\Controllers\\LoginController','login');
addRoute("logout/",'\\LibreMVC\\Modules\\Login\\Controllers\\LoginController','logout');
