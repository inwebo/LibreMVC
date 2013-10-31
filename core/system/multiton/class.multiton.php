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

    public $readOnly = false;
    protected  static $instances;

    private function __construct() {}
    private function __clone() {}

    /**
     * Retourne
     *
     * @param string $name
     * @return Mixed
     */
    static public function get( $name ) {
        $calledClass = get_called_class();

        if( is_null( $calledClass::$instances ) ) {
            $calledClass::$instances = new \StdClass();
        }

        if( !isset( $calledClass::$instances->$name ) ) {
            $calledClass::$instances->$name = new $calledClass;
        }

        return $calledClass::$instances->$name;
    }

    static public function self() {
        $calledClass = get_called_class();
        return $calledClass::$instances;
    }

    /**
     * Setter
     */
    public function __set($key, $value) {
        if( !$this->readOnly ) {
            $this->$key = $value;
        }
    }

    /**
     * Getter
     */
    public function __get($key) {
        if (isset($this->$key)) {
            return $this->$key;
        }
    }

}