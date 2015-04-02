<?php
// Autoloader
include('core/autoloader/autoload.php');
include('core/string/class.string.php');
include('core/helpers.php');

use LibreMVC\Autoloader;
use LibreMVC\Autoloader\Decorators;
use LibreMVC\Autoloader\Handler;
use LibreMVC\System\Boot;
use LibreMVC\System\Boot\Tasks\Events;
use LibreMVC\System\Boot\Tasks\MVC;
use LibreMVC\System;
use LibreMVC\View\ViewObject;
use LibreMVC\View;
use LibreMVC\View\Template;

try {
    // Autoloader
    Handler::addDecorator(new Decorators('core'));
    spl_autoload_register( "\\LibreMVC\\Autoloader\\Handler::handle" );
    $boot = new Boot(
        new Events("Logger"),
        new MVC('config/config.ini'),
        System::this()
    );
    $boot->start();
}
catch (\Exception $e) {

}