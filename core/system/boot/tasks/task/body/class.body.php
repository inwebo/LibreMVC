<?php

namespace LibreMVC\System\Boot\Tasks\Task {

    use LibreMVC\Exception;
    use LibreMVC\System\Boot\Tasks\Task;
    use LibreMVC\System\Hooks;
    use LibreMVC\View\Template;
    use LibreMVC\View;

    class Body extends Task{

        const BODY_PATH = "%s%s/%s.php";

        public function __construct(){
            parent::__construct();
            $this->_name ='Layout';
        }

        protected function start() {
            parent::start();
        }

        protected function body(){
            // {controller}/{action}.php
            $viewsBaseDir   = self::$_instancePaths->getBaseDir()['views'];
            if(is_object(self::$_routed) && class_exists(self::$_routed->controller)) {
                $controller     = self::$_routed->controller;
                $body  = sprintf(self::BODY_PATH,$viewsBaseDir , $controller::getControllerName() , self::$_routed->action);
                try {
                    self::$_layout->attachPartial('body',$body);
                }
                catch(\Exception $e) {
                    self::$_exceptions[] = $e;
                }
            }
            else {
                //throw new Exception('');
            }

        }

        protected function end() {
            parent::end();
        }

    }
}