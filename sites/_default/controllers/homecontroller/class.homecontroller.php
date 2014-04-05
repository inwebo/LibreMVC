<?php
namespace LibreMVC\Controllers;

use LibreMVC\Form;
use LibreMVC\Mvc\Controller;
use LibreMVC\Database;
use LibreMVC\Instance;
use LibreMVC\Views;
use LibreMVC\Mvc\Environnement;
use LibreMVC\Errors;

class HomeController extends \LibreMVC\Mvc\Controller\PageController {

    public function indexAction() {
        $this->_view->vo->title ="Welcome home visitors from futur!";
        $this->_view->render();
    }

    public function debugAction() {
        $this->_breadCrumbs->items->debug="";
        ViewBag::get()->env = Environnement::this();
        $this->_meta->title ="Var_Dump!";
        $this->_view->render();
    }

    public function loginAction() {
        $this->_breadCrumbs->items->login=null;
        $this->_meta->title = "Please login";
        Views::renderAction();
    }

}