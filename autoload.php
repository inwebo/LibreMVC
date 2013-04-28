<?php
include("core/autoloader/class.autoloader.php");

try {
    spl_autoload_register( "\\LibreMVC\\AutoLoader::handler" );
    \LibreMVC\Autoloader::addPool("core/");
    new \LibreMCV\Modules\Foo();

    if(php_sapi_name() == 'cli') {
        echo 'Yeah';
    }


} catch (\Exception $e) {
    $message = time() . ',' . $e->getCode() . ',' . $e->getFile() . ',' . $e->getLine() . ',' . $e->getMessage() . "\n";
    echo $message;
}
