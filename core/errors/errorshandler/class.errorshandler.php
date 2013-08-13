<?php

namespace LibreMVC\Errors;

// Include manuel car autoloader n'est pas encore prêt
include(dirname(__DIR__) . '/class.errors.php');

use LibreMVC\Errors;

class ErrorsHandler {
    
    static public $stack = array();
    
    static public function add ($errno, $errstr, $errfile, $errline, $errcontext) {
        self::$stack[] = new Errors($errno, $errstr, $errfile, $errline, $errcontext);
    }
    
    static public function display() {
        foreach(self::$stack as $value) {
            echo $value->__ToString();
        }
    }
}