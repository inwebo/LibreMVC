<?php
namespace LibreMVC\Mvc\FrontController\Decorator {

    use LibreMVC\Mvc\Controller;
    use LibreMVC\Mvc\FrontController\Decorator;

    class AjaxController extends Decorator{

        public function isTyped() {
            return is_subclass_of($this->_controller,$this->getType(), true);
        }

    }
}