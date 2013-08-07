<?php
/**
 * Created by JetBrains PhpStorm.
 * User: julien
 * Date: 07/08/13
 * Time: 13:32
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Controllers;
use LibreMVC\Http\Header;
use LibreMVC\Mvc\Controllers\PageController;
use LibreMVC\Views;

class BookmarkController extends PageController{

    public function __construct() {
        parent::__construct();
    }

    public function indexAction(){
        echo 'bookmark index';
    }
}