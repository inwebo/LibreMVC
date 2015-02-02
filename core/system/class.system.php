<?php

namespace LibreMVC;

use LibreMVC\Files\Config;
use LibreMVC\Http\Request;
use LibreMVC\Modules\AuthUser\Models\AuthUser;
use LibreMVC\Routing\Route;
use LibreMVC\View\ViewObject;
use LibreMVC\Web\Instance;
use LibreMVC\Web\Instance\PathsFactory\Path;

class System {

    /**
     * @var System
     */
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
    public $routed;

    /**
     * @var array[Module]
     */
    public $modules = array();

    /**
     * @var AuthUser
     */
    public $defaultUser;

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

    public function getModule($name){
        return (isset($this->modules[$name])) ? $this->modules[$name] : null;
    }

    public function getModules(){
        return $this->modules;
    }

    public function getPaths($wich) {

        switch($wich) {
            case "base":
                return $this->basePaths;

            case "app":
                return $this->appPaths;

            case "instance":
                return $this->instancePaths;

            default:
                return null;
        }

    }

    public function getRoute(){
        return $this->routed;
    }

    public function getBaseDirs($el=null){
        return $this->basePaths->getBaseDir($el);
    }

    public function getBaseUrls($el=null){
        return $this->basePaths->getBaseUrl($el);
    }

    public function getInstanceBaseDirs($el=null){
        return $this->instancePaths->getBaseDir($el);
    }

    public function getInstanceBaseUrls($el=null){
        return $this->instancePaths->getBaseUrl($el);
    }

    public function getModuleBaseDirs($module, $el = null){
        return $this->getModule($module)->getPath()->getBaseDir($el);
    }

    public function getModuleBaseUrl($module, $el = null){
        return $this->getModule($module)->getBaseUrl($el);
    }

}