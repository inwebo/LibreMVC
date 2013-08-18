<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 18/08/13
 * Time: 00:17
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\System;


class Multiton {

    /**
     * Instances PDO valides nommées.
     * @var Database
     */
    static private $instancies;

    private function __construct() {}
    private function __clone() {}

    /**
     * Retourne une instance nommée PDO valid.
     *
     * @param string $name
     * @return Mixed
     */
    static public function get( $name ) {
        if( isset( self::$instancies->$name ) ) {
            return self::$instancies->$name;
        }
        else {
            $c = __CLASS__;
            self::$instancies->$name = new $c;
            return self::$instancies->$name;
        }
    }

    static public function toObject() {
        return self::$instancies;
    }

}