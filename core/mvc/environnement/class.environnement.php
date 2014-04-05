<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 04/08/13
 * Time: 17:25
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Mvc;


class Environnement {

    protected $readOnly = false;
    public $controller;
    public $action;
    public $params;
    public $routedRoute;
    public $log;
    public $viewPath;
    public $instance;
    public $paths;
    public $baseUrls;
    public $vo;

    /**
     * Instance unique du ViewBag
     *
     * @param object $instance contient l'instance courante.
     * @static
     */
    protected static $_instance;

    /**
     * Constructeur privé.
     * Pattern singleton
     */
    private function __construct() {}

    /**
     * @param $bool
     */
    public function readOnly($bool) {
        if(is_bool($bool)) {
            $this->readOnly = $bool;
        }
    }

    /**
     * Retourne l'instance courante d'un objet singleton ViewBag
     *
     * @return ViewBag ViewBag courant
     * @static
     */
    public static function this() {
        if ( !isset( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
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