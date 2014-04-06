<?php
namespace LibreMVC\Controllers;

use LibreMVC\Form;
use LibreMVC\Html\Document\Head;
use LibreMVC\Mvc\Controller;
use LibreMVC\Database;
use LibreMVC\Instance;
use LibreMVC\Views;
use LibreMVC\Mvc\Environnement;
use LibreMVC\Errors;
use LibreMVC\Mvc\Controller\PageController;

class HomeController extends PageController {

    public function indexAction() {
        $this->_head->title       = "Welcome home visitors from futur!";
        $this->_head->description = "description";
        $this->_view->render();
    }

    public function debugAction() {
        $this->_view->render();
    }

    public function loginAction() {
        $this->_view->render();
    }

}