<?php

namespace LibreMVC\System\Boot\Tasks\Task {

    use LibreMVC\System\Boot\Tasks\Task;
    use LibreMVC\System\Hooks;
    use LibreMVC\View\ViewObject;
    use LibreMVC\View\Template;
    use LibreMVC\View;

    class Layout extends Task{

        public function __construct(){
            parent::__construct();
            $this->_name ='Layout';
        }

        protected function start() {
            parent::start();
        }

        protected function viewObject() {
            self::$_viewObject = new ViewObject();
            return self::$_viewObject;
        }

        protected function layout(){
            $layout =self::$_instancePaths->getBaseDir('index');

            $layout = new View(
                new Template($layout),
                self::$_viewObject
            );
            self::$_layout = $layout;
            return self::$_layout;
        }

        protected function end() {
            parent::end();
        }

    }
}