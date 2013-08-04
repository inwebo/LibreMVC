<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 04/08/13
 * Time: 17:25
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Mvc;
use LibreMVC\Helpers\Log;

class Environnement {

    public $controller;
    public $action;
    public $params;
    public $route;
    public $log;
    public $viewPath;

    public static $keywords = array('controller','action', 'params', 'log');

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
    private function __construct() {}

    static public function isReserved( $word ) {
        return in_array($word, self::$keywords);
    }

    /**
     * Retourne l'instance courante d'un objet singleton ViewBag
     *
     * @return ViewBag ViewBag courant
     * @static
     */
    public static function get() {
        if ( !isset( self::$instance ) ) {
            self::$instance = new self();
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