<?php
include( dirname(__FILE__) . "/core/autoloader/class.autoloader.php" );
use LibreMVC\Mvc\Environnement;
try {
    include('core/standart.php');
    LibreMVC\AutoLoader::instance()->addPool( './core/' );
    spl_autoload_register( "\\LibreMVC\\AutoLoader::handler" );


    new LibreMVC\System\Boot( new \LibreMVC\System\Boot\Steps() );

    //var_dump(LibreMVC\Mvc\Environnement::this());
} catch (\Exception $e) {
    $message = time() . ',' . $e->getCode() . ',' . $e->getFile() . ',' . $e->getLine() . ',' . $e->getMessage() . "\n";
    echo $message;
}
/*
if(php_sapi_name() == 'cli') {
    echo 'Yeah';
}*/
