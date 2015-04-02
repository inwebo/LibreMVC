<?php
/**
 * Created by PhpStorm.
 * User: inwebo
 * Date: 26/03/15
 * Time: 17:21
 */

namespace LibreMVC\Http\Header;


use LibreMVC\Http\Header;

class Switcher {

    static public function byErrorCode( $error ) {
        switch($error) {
            case 301:
                Header::movedPermanently();
                break;
        }
    }

}