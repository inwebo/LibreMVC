<?php

namespace LibreMVC\System\Hooks {

    class CallBack{

        protected $_closure;
        protected $_reflection;

        public function __construct(\Closure $closure){
            $this->_closure = $closure;
            $this->_reflection = new \ReflectionFunction($this->_closure);
        }

        public function __invoke() {
            $args = func_get_args();
            return $this->_reflection->invokeArgs($args);
        }

        public function getParameters() {
            return $this->_reflection->getParameters();
        }

        public function getClosure() {
            return $this->_closure;
        }

    }
}