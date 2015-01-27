<?php

namespace LibreMVC;

use LibreMVC\Files\Config;
use LibreMVC\Http\Request;
use LibreMVC\Routing\Route;
use LibreMVC\View\ViewObject;
use LibreMVC\Web\Instance;
use LibreMVC\Web\Instance\PathsFactory\Path;

class System {

    protected static $_instance;
    protected $readOnly = false;

    /**
     * @var Request
     */
    public $request;

    /**
     * @var Config
     */
    public $config;

    /**
     * @var Path
     */
    public $basePaths;

    /**
     * @var Path
     */
    public $appPaths;

    /**
     * @var Instance
     */
    public $instance;

    /**
     * @var Path
     */
    public $instancePaths;

    /**
     * @var ViewObject
     */
    public $viewObject;

    /**
     * @var View
     */
    public $layout;

    /**
     * @var Route
     */
    public $route;

    /**
     * @var array
     */
    public $modules = array();

    private function __construct() {}

    public function readOnly($bool) {
        if(is_bool($bool)) {
            $this->readOnly = $bool;
        }
    }

    public static function this() {
        if ( !isset( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __set($key, $value) {
        if( !$this->readOnly ) {
            $this->$key = $value;
        }
    }

    public function __get($key) {
        if (isset($this->$key)) {
            return $this->$key;
        }
    }

}