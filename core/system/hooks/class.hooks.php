<?php
namespace LibreMVC\System {

    use LibreMVC\Patterns\ISingleton;

    class Hooks implements ISingleton{

        protected static $_this;

        protected $_hooks;

        private function __construct() {
            $this->_hooks = array();
        }

        public static function this() {
            if (!isset(self::$_this)) {
                $c = __CLASS__;
                self::$_this = new $c;
            }

            return self::$_this;
        }

        public function createHook($hookName){
            if(!isset($this->_hooks[$hookName])) {
                $this->_hooks[$hookName] = array();
            }
        }

        public function attachHookCallback( $hookName, $function = null) {
            if( !is_null($function) && (is_object($function) && ($function instanceof \Closure)) ) {
                $this->_hooks[$hookName][] = $function;
            }
        }

        public function callHooks($name, &$args = null) {
            $args = func_get_args();
            if(count($args) > 1) {
                unset($args[0]);
            }
            if( isset($this->_hooks[$name]) ) {
                foreach($this->_hooks[$name] as $functions) {
                    call_user_func_array($functions, $args);
                }
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
}
