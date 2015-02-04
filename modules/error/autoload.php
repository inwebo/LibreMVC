<?php
registerModule();
use LibreMVC\Modules\Error;
use LibreMVC\Modules\Error\Controllers\ErrorController;

addRoute('this-is-error', ErrorController::GET,'error','error');
