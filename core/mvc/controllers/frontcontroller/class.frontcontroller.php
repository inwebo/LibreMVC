<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 02/05/13
 * Time: 23:53
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\FrontController;

/**
 * Class FrontController
 * @package LibreMVC\FrontController
 * @todo devrait être indépendant du framework
 */

use LibreMVC\Http\Request;

class FrontController {

    protected $_request;
    protected $_routes;
    protected $_routeAsserts;

    public function __construct( $routes ) {
        $this->_request = Request::current();
        $this->_routes = $routes;
    }

}