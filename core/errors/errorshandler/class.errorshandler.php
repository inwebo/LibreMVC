<?php

namespace LibreMVC\Errors;

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