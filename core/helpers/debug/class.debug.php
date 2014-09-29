<?php
namespace LibreMVC\Helpers;

class Debug {
    
    static public function dump( $var ) {
        echo'<pre>';
        var_dump($var);
        echo'</pre>';
    }
    
}