<?php
namespace LibreMVC\Controllers {

    use LibreMVC\Files\Config;
    use LibreMVC\Mvc\Controller\BaseController;

    use LibreMVC\System;
    use LibreMVC\Database\Drivers;
    use LibreMVC\Database\Driver\MySql;


    class HomeController extends BaseController{

        protected $_config;
        protected $_mysql;

        public function init(){

        }

        public function indexAction(){
            $this->_view->render();
        }

        public function testAction(){
            $this->_view->render();
        }
    }
}