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
 */
class FrontController {

    protected $_request;
    protected $_routes;
    protected $_routeAsserts;

    public function __construct( $routes ) {
        $this->_request = \LibreMVC\Http\Request::current();
        $this->_routes = $routes;
    }

}