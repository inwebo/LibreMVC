<?php

use LibreMVC\System\Boot;
use LibreMVC\System\Boot\Requirements;
use LibreMVC\System\Boot\Mvc;
use LibreMVC\AutoLoader;

// Custom class autoloader.
include( "./core/autoloader/class.autoloader.php" );
// IDE helper.
include('core/standart.php');
// Global functions
include('core/helpers.php');

try {
    // Default framework classes pool
    AutoLoader::instance()->addPool( './core/' );
    // Custom error handler
    spl_autoload_register( "\\LibreMVC\\AutoLoader::handler" );

    // Requirements
    new Boot( new Requirements() );

    if( php_sapi_name() !== 'cli' ) {
        //Boot MVC
        new Boot( new Mvc() );
    }
    else {
        //Boot CLI
        new Boot( new Cli() );
    }

} catch (\Exception $e) {
    // Redirection vers une page ?
    \LibreMVC\Http\Header::serverError();
    var_dump($e);
}