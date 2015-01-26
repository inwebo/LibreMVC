<?php
registerInstance();
addRoute('[:action]','\\LibreMVC\\Controllers\\HomeController','index');
addStaticRoute('static/[:static]');
