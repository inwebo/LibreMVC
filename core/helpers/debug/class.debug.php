<?php
namespace LibreMVC\Helpers;

class Debug {
    
    static public function d( $var ) {
        echo'<pre>';
        var_dump($var);
        echo'</pre>';
    }
    
}