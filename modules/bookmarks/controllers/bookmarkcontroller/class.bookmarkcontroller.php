<?php
/**
 * Created by JetBrains PhpStorm.
 * User: julien
 * Date: 07/08/13
 * Time: 13:32
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Modules\Bookmarks\Controllers;

use LibreMVC\Errors;
use LibreMVC\Form;
use LibreMVC\Http\Header;
use LibreMVC\Mvc\Controllers\RestController;
use LibreMVC\Views;
use LibreMVC\Http\Context;
use LibreMVC\Http\Rest\Client;

class BookmarkController extends RestController{

    public function __construct() {
        parent::__construct();
        //var_dump($_POST);
    }

    public function get($args) {
        $this->public = false;
        $this->validateRequest();
        $this->httpReply->msg = $args[0];
        $this->httpReply->msg = "get";
    }

    public function post($args) {
        //var_dump($args);
        $input = file_get_contents('php://input');
        //$input = parse_str(file_get_contents('php://input'), $_POST);
        //var_dump( $_POST );
        //var_dump($_POST);
        //echo( $_SERVER['REQUEST_METHOD']);
        $this->public = false;
        $this->validateRequest();
        $this->httpReply->msg = json_encode($_POST);
    }

    public function delete($args) {
        //echo __METHOD__;
        //$input = file_get_contents('php://input');
        //$input = parse_str(file_get_contents('php://input'), $_POST);
        //var_dump( $_POST );
    }

    public function put($args) {
        //echo __METHOD__;
        //$input = file_get_contents('php://input');
        $_PUT = array();
        parse_str(file_get_contents('php://input'), $_PUT);
        //var_dump( $_PUT );
        $this->httpReply->msg = json_encode($_PUT);
    }

    protected function isValidUser() {
        return ($this->token === Client::signature($this->user, md5("inwebo"), $this->timestamp));
    }

    public function formAction(){
        //$form = new Form();
        //$this->_viewbag->form = $form->toHtml(true);
        //Views::renderAction();
    }
}