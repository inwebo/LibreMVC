<?php

try {
    // Instance modules
    \LibreMVC\Autoloader::addPool("./");
    \LibreMVC\Autoloader::addPool("controllers");
    echo '<br>Autoload instance.<br>';
    //new \LibreMCV\Modules\Foo\Bar();

} catch (\Exception $e) {
    $message = time() . ',' . $e->getCode() . ',' . $e->getFile() . ',' . $e->getLine() . ',' . $e->getMessage() . "\n";
    echo $message;
}
