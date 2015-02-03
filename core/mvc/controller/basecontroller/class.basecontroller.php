<?php

namespace LibreMVC\Mvc\Controller {
    use LibreMVC\Http\Request;
    use LibreMVC\System;
    use LibreMVC\View;
    use LibreMVC\View\ViewObject;
    use LibreMVC\View\Template;


    abstract class BaseController implements IController {
        const ACTION_SUFFIX = "Action";
        const CONTROLLER_SUFFIX = "Controller";
        /**
         * @var Request
         */
        protected $_request;
        /**
         * @var View
         */
        protected $_view;

        /**
         * @var ViewObject
         */
        protected $_vo;

        /**
         * @var System
         */
        protected $_system;

        public function __construct( Request $request, System $system) {
            $this->_request = $request;
            $this->_system = $system;
            $this->_view    = $this->_system->layout;
            $this->_vo      = $this->_view->getViewObject();
            $this->init();
        }
        protected function init(){

        }
        /**
         * @return Request
         */
        public function getRequest()
        {
            return $this->_request;
        }

        /**
         * @return ViewObject
         */
        public function getVo()
        {
            return $this->_vo;
        }

        static public function getControllerName(){
            $class = get_called_class();
            $class = explode('\\',$class);
            $class = $class[count($class)-1];
            $class = explode(self::CONTROLLER_SUFFIX,$class);
            return strtolower($class[0]);
        }

        public function indexAction() {
            $this->_view->render();
        }

        /**
         * @return View
         */
        public function getView(){
            return $this->_view;
        }

        public function changeLayout($layout) {
            try  {
                $template= new Template($layout);
                $this->_view = new View(
                    $template,
                    $this->_vo
                );
            }
            catch(\Exception $e) {
                var_dump($e);
            }
        }

        public function changePartial($name,$layout) {
            try  {
                $this->getView()->attachPartial($name,$layout);
            }
            catch(\Exception $e) {
                var_dump($e);
            }

        }

        public function toView($key, $value) {
            $this->_vo->$key = $value;
        }

        public function preRender(){}
        public function render(){
            $this->_view->render();
        }
        public function postRender(){}

    }
}