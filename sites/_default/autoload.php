<?php
registerInstance();
addRoute('[:action]','\\LibreMVC\\Controllers\\HomeController','index');
addRoute('private/[:action]','\\LibreMVC\\Controllers\\PrivateController','index');
addRoute('ajax/','\\LibreMVC\\Controllers\\HomeAjaxController','index');
addRoute('privateajax/controller/demo/','\\LibreMVC\\Controllers\\PrivateAjaxHomeController','index');
addStaticRoute('static/[:static]');