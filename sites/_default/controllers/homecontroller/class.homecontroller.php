<?php
namespace LibreMCV\Controllers;

use \LibreMVC\Mvc\Controllers\StandardController as StandardController;
use \LibreMVC\Views;

class HomeController extends StandardController {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        echo 'l ' . __LINE__ . ' : ' . __FILE__ . '<br>';
        Views::renderAction();
    }

    public function test($a) {
        echo 'l ' . __LINE__ . ' : ' . __FILE__ . '<br>';
        echo 'Home controller testAction with ' . $a . ' parameters';
        Views::renderAction();
    }

    public function pouetAction() {
        echo 'l ' . __LINE__ . ' : ' . __FILE__ . '<br>';
        Views::renderAction();
    }

}