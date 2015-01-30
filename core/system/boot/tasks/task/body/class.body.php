<?php

namespace LibreMVC\System\Boot\Tasks\Task {

    use LibreMVC\System\Boot\Tasks\Task;
    use LibreMVC\System\Hooks;
    use LibreMVC\View\Template;
    use LibreMVC\View;

    class Body extends Task{

        public function __construct(){
            parent::__construct();
            $this->_name ='Layout';
        }

        protected function start() {
            parent::start();
        }

        protected function body(){
            // {controller}/{action}.php
            $viewsBaseDir = self::$_instancePaths->getBaseDir()['views'];
            $controller = self::$_routed->controller;
            $body  = $viewsBaseDir .
                $controller::getControllerName() .'/' .
                self::$_routed->action.'.php';
            if( is_file($body) ) {
                self::$_viewObject->attachPartial('body', self::$_layout->partial($body, self::$_viewObject));
            }
            else {
                try {

                }
                catch(\Exception $e) {

                }
                //trigger_error("Body template :" . $body . ' is missing');
            }

        }

        protected function end() {
            parent::end();
        }

    }
}