<?php
registerModule();
use LibreMVC\Modules\Error;
use LibreMVC\Modules\Error\Controllers\ErrorController;

addRoute('error', ErrorController::getCalledClass(),'error','error');
