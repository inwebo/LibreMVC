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
use LibreMVC\Mvc\Controllers\RestController;
use LibreMVC\Views;
use LibreMVC\Http\Context;
class BookmarkController extends RestController{

    public function __construct() {
        // Dans le HEADER http le token = signature, user= user, timestamp
        parent::__construct();
    }

    public function indexAction(){
        switch( strtolower($this->verb) ) {
            case 'get':
                $this->get();
                break;
            case 'post':
                $this->post();
                break;
            case 'update':
                $this->update();
                break;
            case 'delete':
                $this->delete();
                break;
        }
    }

    public function get() {
        Header::ajax();
        var_dump(apache_request_headers());
        echo __METHOD__;
    }

    public function post() {
        echo __METHOD__;
    }

    public function update() {
        echo __METHOD__;
    }

    public function delete() {

    }

}