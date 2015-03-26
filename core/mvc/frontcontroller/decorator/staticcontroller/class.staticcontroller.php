<?php
namespace LibreMVC\Mvc\FrontController\Decorator {

    use LibreMVC\Mvc\Controller;
    use LibreMVC\Mvc\FrontController\Decorator;

    class StaticController extends Decorator{

        public function isValidAction() {
            return true;
        }

        public function isTyped() {
            return is_a($this->_controller, $this->getType(), true);
        }


        public function factory($args=array()){
            $class = new \ReflectionClass($this->_controller);
            $instance = $class->newInstanceArgs($args);
            $action = Controller::getActionShortName($this->_action);
            return $instance->__call($action, $this->_params);
        }
    }
}