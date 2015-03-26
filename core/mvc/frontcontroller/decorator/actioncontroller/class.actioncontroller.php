<?php
namespace LibreMVC\Mvc\FrontController\Decorator {

    use LibreMVC\Mvc\FrontController\Decorator;
    use LibreMVC\View;

    class ActionController extends Decorator{

        public function isTyped() {
            return is_subclass_of($this->_controller,$this->getType(), true);
        }
    }
}