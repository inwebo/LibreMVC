<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 18/08/13
 * Time: 00:16
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\System;

/**
 * Class Singleton
 *
 * Exemple d'utilisation
 *
 * class FooSingleton extends Singleton {
 *      protected static $instance;
 * }
 *
 * @package LibreMVC\System
 */
class Singleton {

    /**
     * Instance
     *
     * @param object $instance contient l'instance courante.
     * @static
     */
    private static $instance;

    /**
     * Constructeur privé.
     * Pattern singleton
     */
    protected function __construct() {}
    private function __clone() {}

    /**
     * Retourne l'instance courante unique
     *
     * @return object
     * @static
     */
    public static function this() {
        $calledClass = get_called_class();

        if (!isset($calledClass::$instance)) {
            $calledClass::$instance = new $calledClass;
        }
        return $calledClass::$instance;
    }

    /**
     * Setter
     */
    public function __set($key, $value) {
        $this->$key = $value;
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