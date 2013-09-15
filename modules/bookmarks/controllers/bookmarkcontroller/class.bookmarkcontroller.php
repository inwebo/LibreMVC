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
    }

    public function get($args) {
        $this->httpReply->msg = $args[0];
    }

    public function post($args) {
        $this->public = false;
        $this->validateRequest();
        $this->httpReply->msg = 'Yeah';
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