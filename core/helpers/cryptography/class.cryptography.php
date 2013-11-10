<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 06/11/13
 * Time: 21:12
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Helpers;


class Cryptography {

    static public function generateKey( $login, $password ) {
        return  base64_encode( hash_hmac( "sha256", $login , $password ) ) ;
    }

}