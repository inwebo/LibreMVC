<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 06/08/13
 * Time: 21:31
 * To change this template use File | Settings | File Templates.
 */
//@todo yeah!
namespace LibreMVC\Mvc\Controllers;

use LibreMVC\Http\Context;
use LibreMVC\Mvc\Controllers\PageController;

class RestController extends  PageController {

    public $verb;
    public $accept = array();
    public $mustBeLogged = true;
    public $content;

    public function __construct() {
        $this->verb = Context::getHttpVerb();
    }

    public function indexAction(){

    }

}