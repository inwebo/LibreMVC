<?php
// Autoloader
include('core/autoloader/autoload.php');
include('core/string/class.string.php');
include('core/helpers.php');

use LibreMVC\Autoloader;
use LibreMVC\Autoloader\Decorators;
use LibreMVC\Autoloader\Handler;
use LibreMVC\System\Boot;
use LibreMVC\System\Boot\MVC;
use LibreMVC\System;

try {
    // Autoloader
    Handler::addDecorator(new Decorators('core'));
    spl_autoload_register( "\\LibreMVC\\Autoloader\\Handler::handle" );

    new Boot( new Mvc('config/config.ini'), System::this() );

}
catch (\Exception $e) {
    var_dump($e);
}