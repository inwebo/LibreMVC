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

    public $paths;
    public $baseUrls;


    public $instance;
    public $route;

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