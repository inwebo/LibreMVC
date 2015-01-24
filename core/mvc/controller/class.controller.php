<?php
namespace LibreMVC\Mvc {

    use LibreMVC\Mvc\Controller\BaseController;

    class Controller extends BaseController {

        public function indexAction() {
            $this->_view->render();
        }

        public function toView($key, $value) {
            $this->_view->getDataProvider()->$key = $value;
        }
    }
}