<?php

namespace LibreMVC;

use LibreMVC\Database\Driver;


/**
 * Class Database
 * @package LibreMVC
 */
class Database {

    /**
     * Instances PDO valides nommées.
     * @var Database
     */
    static private $pool;

    /**
     * Private constructor
     */
    private function __construct() {}

    /**
     * Private magic methode
     */
    private function __clone() {}

    /**
     * Retourne une instance nommée PDO valid.
     *
     * @param string $name
     * @return Mixed
     */
    static public function get( $name ) {
        if( isset( self::$pool->$name ) ) {
            return self::$pool->$name;
        }
    }

    /**
     * @param $name
     * @param $setup
     */
    static public function setup( $name, $setup ) {
        if ( !isset( self::$pool ) ) {
            self::$pool = new \stdClass();
        }

        if ( !isset( self::$pool->$name ) && $setup instanceof Driver ) {
            self::$pool->$name = $setup;
        }
    }

}