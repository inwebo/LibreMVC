<?php

namespace LibreMVC\System\Boot\Tasks\Task {

    use LibreMVC\Controllers\HomeController;
    use LibreMVC\Mvc\Controller;
    use LibreMVC\System;
    use LibreMVC\System\Boot\Tasks\Task;
    use LibreMVC\System\Hooks;
    use LibreMVC\Mvc\FrontController as BaseFrontController;
    use LibreMVC\View\Template;
    use LibreMVC\View;
    use LibreMVC\Mvc\FrontController\Decorator;

    class FrontController extends Task{

        public function __construct(){
            parent::__construct();
            $this->_name = 'FrontController';
        }

        protected function start() {
            parent::start();
        }

        protected function frontController(){
            try {
                $front = new BaseFrontController(
                    self::$_request,
                    System::this()
                );
                // Peupler les Decorator du FrontController
                //if(!is_null(self::$_routed)) {
                //echo HomeController::getCalledClass();
                //echo HomeController::getControllerName();
                    $front->pushDecorator(new Decorator\StaticController(self::$_routed->controller, self::$_routed->action . Controller::SUFFIX_ACTION, Controller\StaticController::getShortCalledClass(), self::$_routed->params));
                    $front->pushDecorator(new Decorator\ActionController(self::$_routed->controller, self::$_routed->action . Controller::SUFFIX_ACTION, Controller\ActionController::getShortCalledClass(), self::$_routed->params));
                    $front->invoker();
                //}

            }
            catch(\Exception $e) {
                self::$_exceptions[] = $e;
                //throw $e;
            }
        }

        protected function end() {
            parent::end();
        }

    }
}