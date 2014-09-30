<?php
namespace LibreMVC\Controllers;

use LibreMVC\Database\Driver;
use LibreMVC\Database\Provider;
use LibreMVC\Models\User;
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

}