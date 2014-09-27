<?php
namespace LibreMVC\Controllers;

use LibreMVC\Models\User;
use LibreMVC\Mvc\Controller\PageController;
use LibreMVC\Routing\RoutesCollection;

class HomeController extends PageController {

    public function indexAction() {
        $this->_head->title       = "Welcome home visitors from futur!";
        $this->_head->description = "description";
        $this->toView("routes", RoutesCollection::getRoutes());
        $this->_view->render();
    }

}