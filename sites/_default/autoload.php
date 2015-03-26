<?php
registerInstance();
addRoute('[:action]','\\LibreMVC\\Controllers\\HomeController','index');
addRoute('private/[:action]','\\LibreMVC\\Controllers\\PrivateController','index');
addRoute('ajax/','\\LibreMVC\\Controllers\\HomeAjaxController','index');
addStaticRoute('static/[:static]');