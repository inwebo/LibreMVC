<?php

namespace LibreMVC\System\Boot\Tasks\Task {

    use LibreMVC\System\Boot\Tasks\Task;
    use LibreMVC\System\Hooks;
    use LibreMVC\View\Template;
    use LibreMVC\View;

    class Exceptions extends Task{

        public function __construct(){
            parent::__construct();
            $this->_name ='Exceptions';
        }

        protected function start() {
            parent::start();
        }

        protected function exceptions() {
            if( count(self::$_exceptions) > 0 ) {
                // Changer body pour celui des exceptions
                //throw self::$_exceptions[0];
                // Check type exceptions
                //var_dump(self::$_exceptions[0]);

            }
        }

        protected function end() {
            parent::end();
        }

    }
}