<?php
include( dirname(__FILE__) . "/core/autoloader/class.autoloader.php" );
use LibreMVC\Mvc\Environnement;
try {
    include('core/standart.php');
    include('core/helpers.php');
    LibreMVC\AutoLoader::instance()->addPool( './core/' );
    spl_autoload_register( "\\LibreMVC\\AutoLoader::handler" );


    //new LibreMVC\System\Boot( 0);
    new LibreMVC\System\Boot( new \LibreMVC\System\Boot\Mvc() );
    //echo \LibreMVC\Http\Context::getServer(true, true);
    //var_dump(LibreMVC\Mvc\Environnement::this());
} catch (\Exception $e) {
    $message = time() . ',' . $e->getCode() . ',' . $e->getFile() . ',' . $e->getLine() . ',' . $e->getMessage() . "\n";
    //echo $message;
    \LibreMVC\Http\Header::serverError();
    \LibreMVC\Views\Template\ViewBag::get()->error = $message;
    include('error500.php');
}
/*
if(php_sapi_name() == 'cli') {
    echo 'Yeah';
}*/
