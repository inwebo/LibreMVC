<?php
/**
 * Created by JetBrains PhpStorm.
 * User: julien
 * Date: 22/04/13
 * Time: 13:09
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Routing;

/**
 * Class RoutesCollection
 *
 * Multiton
 *
 * @package LibreMVC\Routing
 */
class RoutesCollection {

    static protected $instances;
    public $routes;

    public function __construct(){
        $this->routes = new \SplObjectStorage();
    }

    static public function get( $name ) {

        if( is_null( self::$instances ) ) {
            self::$instances = new \StdClass();
        }

        if( !isset( self::$instances->$name ) ) {
            self::$instances->$name = new self;
        }

        return self::$instances->$name;
    }

    public function addRoute(Route $route) {
        $this->routes->attach($route);
    }

    public function getDefaultRoute() {
        $this->routes->rewind();
        return $this->routes->current();
    }

    public function reset() {
        $this->routes = new \SplObjectStorage();
    }

    public function getRoutes() {
        return $this;
    }

    public function toString() {
        return $this->routes->serialize();
    }

    public function hasRoute( Route $route ) {
        return $this->routes->offsetExists($route);
    }


    /*
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

    static public function getDefaultRoute() {
        // Est la premiere de la pile FILO
    }

    static public function reset() {
        self::$routes = array();
    }*/



}