<?php
/**
 * Created by PhpStorm.
 * User: inwebo
 * Date: 23/03/15
 * Time: 15:40
 */

namespace LibreMVC\Mvc\FrontController\Decorator;


use LibreMVC\Http\Request;
use LibreMVC\Mvc\FrontController\Decorator;
use LibreMVC\View;

class ActionController extends Decorator{

    const TYPE = '\\LibreMVC\Mvc\\Controller\\ActionController';

    public function isTyped() {
        return is_subclass_of($this->_controller, static::TYPE, true);
    }
}