<?php
namespace LibreMVC\Controllers;

use LibreMVC\Core\Views\ViewBag;
use LibreMVC\Http\Request;
use LibreMVC\Database;
use LibreMVC\Instance;
use LibreMVC\Mvc\Controllers\PageController;
use LibreMVC\Views;
use LibreMVC\Mvc\Environnement;

class HomeController extends PageController {

    public function __construct() {
        parent::__construct();
        $this->_viewbag->baseHref = Environnement::this()->instance->baseUrl;
        $this->_viewbag->menus = $this->toMenuEntries();

    }

    public function indexAction() {
        $this->_viewbag->demoViewBag = "Depuis le viewbag !";
        Views::renderAction();
    }

    public function testAction($a = '') {
        echo 'l ' . __LINE__ . ' : ' . __FILE__ . '<br>';
        echo 'Home controller testAction with ' . $a . ' parameters';

        Views::renderAction();
    }

    public function pouetAction() {
        echo 'l ' . __LINE__ . ' : ' . __FILE__ . '<br>';
        Views::renderAction();
    }

    public function debugAction() {
        Views\Template\ViewBag::get()->instance = new \LibreMVC\Instance( \LibreMVC\Http\Context::getUrl() );
        $instance = new \LibreMVC\Instance( \LibreMVC\Http\Context::getUrl() );
        $paths = $instance->processPattern( \LibreMVC\Files\Config::load( "config/paths.ini" ), "home", 'index' );
        Views\Template\ViewBag::get()->paths = $paths;
        $router = new \LibreMVC\Routing\Router( \LibreMVC\Http\Uri::current(), \LibreMVC\Routing\RoutesCollection::getRoutes(), \LibreMVC\Routing\UriParser\Asserts::load() );
        Views\Template\ViewBag::get()->router = $router;
        Views\Template\ViewBag::get()->routedRoute = $router->dispatch();

        Views::renderAction();
    }

    public function requestAction() {
        Views\Template\ViewBag::get()->request = Request::current();
        Views\Template\ViewBag::get()->instance = new \LibreMVC\Instance( \LibreMVC\Http\Context::getUrl() );
        Views::renderAction();
    }
}