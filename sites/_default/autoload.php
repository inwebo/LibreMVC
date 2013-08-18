<?php

try {
    LibreMVC\AutoLoader::instance()->addPool( './' );
/*
    \LibreMVC\System\Multiton::get("test")->arf = "pouet";
    var_dump(\LibreMVC\System\Multiton::get("test"));
    \LibreMVC\System\Multiton::get("test")->a = "s";
    \LibreMVC\System\Multiton::get("foo")->bar = "+";
    var_dump(\LibreMVC\System\Multiton::toObject());
*/
} catch (\Exception $e) {
    $message = time() . ', ' . $e->getCode() . ', ' . $e->getFile() . ', ' . $e->getLine() . ', ' . $e->getMessage() . "\n";
    //echo $message;
}
