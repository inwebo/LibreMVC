<?php
try {
    $phar = new Phar( __DIR__ . '/LibreMVC.phar' );
    $phar->buildFromDirectory(__DIR__ . '/../core', '/\.php$/');
    $phar->stopBuffering();
}
catch(Exception $e) {
    echo $e->getMessage();
}