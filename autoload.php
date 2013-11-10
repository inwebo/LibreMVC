<?php


use LibreMVC\Mvc\Environnement;
use LibreMVC\System\Boot;
use LibreMVC\System\Boot\Mvc;

try {
    LibreMVC\AutoLoader::instance()->addPool( './core/' );
    spl_autoload_register( "\\LibreMVC\\AutoLoader::handler" );

    if(php_sapi_name() !== 'cli') {
        //Boot MVC
        new Boot( new Mvc() );
    }
    else {
        //Boot cli
    }

    new Boot(new Boot\Requirements());

    var_dump(\LibreMVC\Errors\ErrorsHandler::$stack);
    if( isset($_GET['q']) ) {
        echo $_GET['q'];
    }
} catch (\Exception $e) {
    $message = time() . ',' . $e->getCode() . ',' . $e->getFile() . ',' . $e->getLine() . ',' . $e->getMessage() . "\n";
    //echo $message;
    //var_dump($e);
    //echo get_class($e);
    \LibreMVC\Http\Header::serverError();
    \LibreMVC\Views\Template\ViewBag::get()->exception = $e;
    include('error500.php');
}

