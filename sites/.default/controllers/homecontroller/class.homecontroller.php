<?php
namespace LibreMVC\Controllers;

use LibreMVC\Database\Driver;
use LibreMVC\Database\Provider;
use LibreMVC\Models\User;
use LibreMVC\Mvc\Controller\PageController;
use LibreMVC\Mvc\Environnement;
use LibreMVC\Routing\RoutesCollection;

class HomeController extends PageController {

    public function indexAction() {
        $this->_head->title       = "Welcome home visitors from futur!";
        $this->_head->description = "description";

        $this->toView("routes", RoutesCollection::getRoutes());

        $this->_view->render();
    }

    public function debugAction() {
        $user = User::load('inwebo','login');
        //var_dump($user);
        $user = new User('inwebo','I_kvrg1hir!.net', '3petitscochons', 'inwebo@gmail.com');
        //var_dump($user);
        $this->_view->render();
    }

    public function loginAction() {
        $this->_view->render();
    }

    public function bookmarksAction() {
        Provider::add("bookmarks",new Driver\MySql("localhost","inwebourl","root","root"));
        Provider::get("bookmarks")->toStdClass();
        var_dump(Provider::get("bookmarks")->query('select * from my_tables_bookmarks')->all());
        $this->_view->render();
    }

    public function ajaxAction() {
        $this->_view->render();
    }

}