<?php

namespace LibreMVC\System\Boot\Tasks\Task {

    use LibreMVC\Http\Header;
    use LibreMVC\System;
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
                Header::notFound();
                self::$_viewObject->exception = self::$_exceptions[0];
                self::$_viewObject->debug = self::$_debug;
                self::$_layout->attachPartial('body', System::this()->getInstanceBaseDirs('static_views') . 'error.php');
                self::$_layout->render();
            }
        }

        protected function end() {
            parent::end();
        }

    }
}