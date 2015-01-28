<?php

namespace LibreMVC\Mvc\Controller {
    use LibreMVC\Http\Request;
    use LibreMVC\View;
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
         * @var IDataProvider
         */
        protected $_data;

        public function __construct( Request $request, View $view ) {
            $this->_request = $request;
            $this->_view    = $view;
            $this->_data    = $this->_view->getDataProvider();
            $this->init();
        }

        protected function init() {}

        /**
         * @param $action
         * @return bool
         */
        public function hasAction( $action ) {
            return (bool)method_exists( $this, $action . self::ACTION_SUFFIX );
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

        public function toView($key, $value) {
            $this->_data->$key = $value;
        }
    }
}