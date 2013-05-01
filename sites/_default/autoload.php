<?php

try {
    // Instance modules
    \LibreMVC\Autoloader::addPool("./");
    \LibreMVC\Autoloader::addPool("./controllers/");
    echo 'l ' . __LINE__ . ' : ' . __FILE__ . '<br>';

} catch (\Exception $e) {
    $message = time() . ',' . $e->getCode() . ',' . $e->getFile() . ',' . $e->getLine() . ',' . $e->getMessage() . "\n";
    echo $message;
}
