<?php

namespace LibreMVC\Mvc\Controller {
    use LibreMVC\Http\Request;
    use LibreMVC\View;
    use LibreMVC\View\Parser\Logic\Template;
    use LibreMVC\View\Interfaces\IDataProvider;

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
         * @var View\ViewObject
         */
        protected $_vo;

        public function __construct( Request $request, View $view ) {
            $this->_request = $request;
            $this->_view    = $view;
            $this->_vo      = $this->_view->getDataProvider();
            /**
             * System !
             */
            $this->init();
        }

        protected function init() {}

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
                $this->_vo->attachPartial($name,$layout);
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