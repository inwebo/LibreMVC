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
                $controller::getControllerName() . '/' .
                self::$_routed->action . '.php';
                try {
                    self::$_layout->attachPartial('body',$body);
                }
                catch(\Exception $e) {
                    //var_dump($e);
                }
        }

        protected function end() {
            parent::end();
        }

    }
}