<?php
namespace LibreMVC\Controllers {

    use LibreMVC\Mvc\Controller\ActionController;

    class HomeController extends ActionController{

        public function getFile(){
            return __FILE__;
        }
    }
}