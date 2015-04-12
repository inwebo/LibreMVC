<?php

namespace LibreMVC\System\Boot\Tasks\Task {

    use LibreMVC\Mvc\Controller;
    use LibreMVC\System;
    use LibreMVC\System\Boot\Tasks\Task;
    use LibreMVC\System\Hooks;
    use LibreMVC\Mvc\FrontController as BaseFrontController;
    use LibreMVC\View\Template;
    use LibreMVC\View;
    use LibreMVC\Mvc\FrontController\Decorator;

    class FrontController extends Task {

        public function __construct(){
            parent::__construct();
            $this->_name = 'FrontController';
        }

        protected function start() {
            parent::start();
        }

        static private function getRoutedAction() {
            return self::$_routed->action . Controller::SUFFIX_ACTION;
        }

        protected function frontController(){
            try {
                $front = new BaseFrontController(
                    self::$_request,
                    System::this()
                );
                if( count(self::$_exceptions) === 0 ) {
                    $front->pushDecorator(new Decorator\StaticController(self::$_routed->controller, self::getRoutedAction(), Controller\StaticController::getCalledClass(), self::$_routed->params));
                    $front->pushDecorator(new Decorator\ActionController(self::$_routed->controller, self::getRoutedAction(), Controller\ActionController::getCalledClass(), self::$_routed->params));
                    $front->pushDecorator(new Decorator\AuthController(self::$_routed->controller, self::getRoutedAction(), Controller\AuthController::getCalledClass(), self::$_routed->params));
                    $front->pushDecorator(new Decorator\AjaxController(self::$_routed->controller, self::getRoutedAction(), Controller\AjaxController::getCalledClass(), self::$_routed->params));
                    $front->pushDecorator(new Decorator\PrivateAjaxController(self::$_routed->controller,self::getRoutedAction(),Controller\AjaxController\PrivateAjaxController::getCalledClass(),self::$_routed->params));
                    $front->invoker();
                }
            }
            catch(\Exception $e) {
                self::$_exceptions[] = $e;
            }
        }

        protected function end() {
            parent::end();
        }

    }
}