<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 13/10/13
 * Time: 14:25
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Database;

use LibreMVC\Database\Driver\IDriver;
use LibreMVC\Database\Statement;

class Provider {

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

    static public function add( $name, IDriver $driver ) {
        if ( !isset( self::$pool ) ) {
            self::$pool = new \stdClass();
        }
        if ( !isset( self::$pool->$name ) ) {
            $statement = new Statement( $driver );
            self::$pool->$name = $statement;
        }
    }

}