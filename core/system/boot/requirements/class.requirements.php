<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 09/11/13
 * Time: 12:31
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\System\Boot;


class Requirements {

    const PHP_VERSION = 5.4;

    static public function isValidPhpVersion() {
        $version = (float)substr(phpversion(), 0, 3);
        if(!($version >= (float)self::PHP_VERSION)) {
            trigger_error('Require at least php '. self::PHP_VERSION .', you ve got ' . PHP_VERSION);
        }
    }

    static public function isValidCacheDir() {
        /*$version = (float)substr(phpversion(), 0, 3);
        if(!($version >= (float)self::PHP_VERSION)) {
            trigger_error('Require at least php '. self::PHP_VERSION .', you ve got ' . PHP_VERSION);
        }*/
    }

}