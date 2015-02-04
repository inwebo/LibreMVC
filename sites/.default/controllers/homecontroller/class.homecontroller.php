<?php
namespace LibreMVC\Controllers {

    use LibreMVC\Mvc\Controller\BaseController;
    use LibreMVC\System;

    class HomeController extends BaseController{

        /**
         * Custom constructor
         */
        public function init(){

        }

        public function indexAction(){
            $this->render();
        }
    }
}