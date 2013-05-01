<?php
namespace LibreMCV\Controllers;

use \LibreMVC\Mvc\Controllers\StandardController as StandardController;
use \LibreMVC\Views;

class HomeController extends StandardController {

    public function __construct() {
        parent::__construct();
    }

    public function indexAction() {
        echo 'Home controller indexAction';
        Views::renderAction();
    }

    public function pouetAction() {
        echo __NAMESPACE__;
        Views::renderAction();
    }

    public function testAction($a) {
        echo 'Les parmametres de l invocation = '.$a.'<br>';
        Views::renderAction();
    }

}