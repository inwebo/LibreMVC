<?php

try {
    LibreMVC\AutoLoader::instance()->addPool( './' );
} catch (\Exception $e) {
    $message = time() . ',' . $e->getCode() . ',' . $e->getFile() . ',' . $e->getLine() . ',' . $e->getMessage() . "\n";
    //echo $message;
}
