<?php
namespace LibreMVC\Mvc {

    use LibreMVC\Mvc\Controller\IController;
    use LibreMVC\Http\Request;
    use LibreMVC\System;
    use LibreMVC\View;

    abstract class Controller implements IController{
        const SUFFIX_ACTION     = "Action";
        const SUFFIX_CONTROLLER = "Controller";
        const FILE_EXTENSION    = ".php";

        const VIEW_DEFAULT_PATH_FORMAT = "{controller}/{action}{ext}";

        /**
         * @var Request
         */
        protected $_request;
        /**
         * @var View
         */
        protected $_view;
        /**
         * @var string Current file
         */
        protected $_file;

        public function __construct( Request $request, View $view ) {
            $this->_request = $request;
            $this->_view    = $view;
            $this->init();
        }

        /**
         * @return string
         */
        public function getFile()
        {
            return __FILE__;
        }

        protected function init(){}

        /**
         * @return View\ViewObject
         */
        protected function getVo() {
            return $this->_view->getViewObject();
        }

        public function toView($key, $value) {
            $this->getVo()->$key = $value;
        }
        public function render(){
            $this->_view->render();
        }

        public function changePartial($name,$path) {
            try  {
                $this->getView()->attachPartial($name,$path);
            }
            catch(\Exception $e) {
                return $e;
            }

        }

        /**
         * @return View
         */
        public function getView()
        {
            return $this->_view;
        }

        /**
         * @return Request
         */
        public function getRequest()
        {
            return $this->_request;
        }

        static public function getCalledClass() {
            return get_called_class();
        }

        static public function getShortCalledClass() {
            $class = get_called_class();
            $class = explode('\\',$class);
            return $class[count($class)-1];
        }

        static public function getControllerName() {
            $class = get_called_class();
            $class = explode('\\',$class);
            $class = $class[count($class)-1];
            $class = explode(self::SUFFIX_CONTROLLER, $class);
            return strtolower($class[0]);
        }

        static public function getActionShortName($name) {
            return explode(self::SUFFIX_ACTION,$name)[0];
        }

        /**
         * @return mixed
         * @todo
         */
        public function getViewFilePath() {
            return str_replace(
                array(
                    '{controller}',
                    '{action}',
                    '{ext}'
                ),
                array(

                ),
                self::VIEW_DEFAULT_PATH_FORMAT
            );
        }
    }

}

/* ActionController
    - Est chargé de retourner le nom complet de l'action après nettoyage. */

