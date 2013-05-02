<?php
namespace LibreMCV\Controllers;

use LibreMCV\Http\Request;
use \LibreMVC\Mvc\Controllers\StandardController as StandardController;
use \LibreMVC\Views;

class HomeController extends StandardController {

    public function __construct() {
        parent::__construct();
    }

    public function indexAction() {
        Views\Template\ViewBag::get()->demoViewBag = "Depuis le viewbag !";
        Views::renderAction();
    }

    public function testAction($a) {
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

        $router = new \LibreMCV\Routing\Router( \LibreMCV\Http\Uri::current(), \LibreMCV\Routing\RoutesCollection::getRoutes(), \LibreMCV\Routing\UriParser\Asserts::load() );
        Views\Template\ViewBag::get()->router = $router;
        Views\Template\ViewBag::get()->routedRoute = $router->dispatch();

        Views::renderAction();
    }

    public function requestAction() {
        Views\Template\ViewBag::get()->request = Request::current();
        var_dump(Request::current()->toArray());
        $instance = new \LibreMVC\Instance( \LibreMVC\Http\Context::getUrl() );
        var_dump($instance);
        Views::renderAction();
    }
}