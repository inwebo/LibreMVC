<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 05/08/13
 * Time: 23:00
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Mvc\Controllers;


use LibreMVC\Http\Header;
use LibreMVC\Mvc\Controllers\PageController;
use LibreMVC\Views;
use LibreMVC\Mvc;

class ErrorsController {

    public function __construct() {
        //parent::__construct();
    }

    public function error404Action() {
        Views::renderAction();
    }

    static public function throwHttpError( $httpErrorNumber ) {
        Header::error($httpErrorNumber);
        $controller = new ErrorsController();
        $controller->error404Action();
        exit();
    }

}