<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 01/02/14
 * Time: 23:32
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Mvc\Controller;

use LibreMVC\Html\Document\Head;
use LibreMVC\Mvc\Controller;

class PageController extends Controller {

    protected $_head;

    public function init(){
        $this->_view->vo->_head = new Head();
    }

}