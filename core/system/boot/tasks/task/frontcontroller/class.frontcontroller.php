<?php

namespace LibreMVC\System\Boot\Tasks\Task {

    use LibreMVC\System;
    use LibreMVC\System\Boot\Tasks\Task;
    use LibreMVC\System\Hooks;
    use LibreMVC\Mvc\FrontController as BaseFrontController;
    use LibreMVC\View\Template;
    use LibreMVC\View;
    use LibreMVC\Routing\RoutesCollection;

    class FrontController extends Task{

        public function __construct(){
            parent::__construct();
            $this->_name ='FrontController';
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
                $front->invoker();
            }
            catch(\Exception $e) {
                $default = RoutesCollection::get(('error'))->getDefaultRoute();
                $front->attachDefaultRoute($default);
                $front->invoker();
            }
        }

        protected function end() {
            parent::end();
        }

    }
}