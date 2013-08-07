<?php
/**
 * Created by JetBrains PhpStorm.
 * User: julien
 * Date: 07/08/13
 * Time: 13:32
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Controllers;
use LibreMVC\Errors;
use LibreMVC\Http\Header;
use LibreMVC\Mvc\Controllers\PageController;
use LibreMVC\Views;
use LibreMVC\Http\Context;
class BookmarkController extends PageController{

    public function __construct() {
        parent::__construct();
    }

    public function indexAction(){
        Header::ajax();
        Header::json();
        Header::hideInfos();
        $err = new Errors(2,'Error',__FILE__, __LINE__, __CLASS__);
        echo json_encode($err);
    }

    public function get() {

    }

    public function post() {

    }

    public function update() {

    }

    public function delete() {

    }

    public function testAction(){
        echo __METHOD__;
        return;
    }

}