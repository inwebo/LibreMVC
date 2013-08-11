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
use LibreMVC\Mvc\Controllers\RestController;
use LibreMVC\Views;
use LibreMVC\Http\Context;
class BookmarkController extends RestController{


    public function __construct() {
        parent::__construct();
    }

    public function get() {
        $this->httpReply->msg = 'Get';
    }



}