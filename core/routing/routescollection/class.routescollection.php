<?php
/**
 * Created by JetBrains PhpStorm.
 * User: julien
 * Date: 22/04/13
 * Time: 13:09
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Routing;


class RoutesCollection {

    static public $routes = array();

    public function __construct(){}

    static public function load(){
        return self::$routes;
    }

    static public function addRoute($route) {
        self::$routes[] = $route;
    }

    static public function getRoute($route) {
        if(isset(self::$routes[$route])) {
            return self::$routes[$route];
        }
    }

    static public function getRoutes() {
        return self::$routes;
    }

    static public function delRoute( $route ) {
        if(isset(self::$routes[$route])) {
            unset(self::$routes[$route]);
        }
    }

    static public function reset() {
        self::$routes = array();
    }
}