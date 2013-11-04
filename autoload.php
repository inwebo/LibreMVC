<?php
include( dirname(__FILE__) . "/core/autoloader/class.autoloader.php" );
include('core/standart.php');
include('core/helpers.php');

use LibreMVC\Mvc\Environnement;
use LibreMVC\System\Boot;
use LibreMVC\System\Boot\Mvc;

try {
    LibreMVC\AutoLoader::instance()->addPool( './core/' );
    spl_autoload_register( "\\LibreMVC\\AutoLoader::handler" );

    if(php_sapi_name() !== 'cli') {
        new Boot( new Mvc() );
    }
    else {
        // Boot cli
    }


} catch (\Exception $e) {
    $message = time() . ',' . $e->getCode() . ',' . $e->getFile() . ',' . $e->getLine() . ',' . $e->getMessage() . "\n";
    //echo $message;
    //var_dump($e);
    //echo get_class($e);
    \LibreMVC\Http\Header::serverError();
    \LibreMVC\Views\Template\ViewBag::get()->error = $message;
    include('error500.php');
}

