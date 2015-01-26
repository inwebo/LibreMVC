<?php
registerModule();
use LibreMVC\Modules\Error;
use LibreMVC\Modules\Error\Controllers\ErrorController;
$route = new \LibreMVC\Routing\Route('this-is-error');
$route->controller = ErrorController::GET;
$route->action = 'error';

\LibreMVC\Routing\RoutesCollection::get("error")->addRoute($route);

