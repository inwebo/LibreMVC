<?php

namespace LibreMVC\Database {

    use LibreMVC\Database\Driver\IDriver;

    class Provider {

        static private $_instances;

        private function __construct() {}

        private function __clone() {}


        static public function get( $name ) {
            if( isset( self::$_instances->$name ) ) {
                return self::$_instances->$name;
            }
        }

        /**
         * Add a database driver $driver into named $name pool.
         * @param string $name
         * @param IDriver $driver
         */
        static public function add( $name, IDriver $driver ) {
            if ( !isset( self::$_instances ) ) {
                self::$_instances = new \stdClass();
            }
            if ( !isset( self::$_instances->$name ) ) {
                $statement = new Statement( $driver );
                self::$_instances->$name = $statement;
            }
        }

    }
}