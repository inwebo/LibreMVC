<?php
namespace LibreMVC\System;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of class
 *
 * @author julien
 */
class Hooks {

    protected static $instance;

    public $hooks;

    private function __construct() {
        $this->hooks = array();
    }

    public static function get() {
        if (!isset(self::$instance)) {
            $c = __CLASS__;
            self::$instance = new $c;
        }

        return self::$instance;
    }

    public function addHook( $hookName, $function = null) {
        $this->hooks[$hookName][] = $function;
    }

    public function callHooks($name) {
        foreach($this->hooks[$name] as $functions) {
            $functions->__invoke();
        }
    }

    public function __set($key, $value) {
        $this->$key = $value;
    }

    public function __get($key) {
        if (isset($this->$key)) {
            return $this->$key;
        }
    }
    
}
