<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 08/09/13
 * Time: 15:27
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Helpers;


class BreadCrumbs {

    public $items;

    /**
     * Instance unique du ViewBag
     *
     * @param object $instance contient l'instance courante.
     * @static
     */
    protected static $instance;

    /**
     * Constructeur privé.
     * Pattern singleton
     */
    private function __construct() {
        $this->items = new \StdClass();
    }
    private function __clone() {}

    /**
     * Retourne l'instance courante unique
     *
     * @return object
     * @static
     */
    public static function this() {
        if (!isset(self::$instance)) {
            $c = get_called_class();
            self::$instance = new $c;
        }

        return self::$instance;
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