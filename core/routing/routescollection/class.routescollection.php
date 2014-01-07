<?php
/**
 * Created by JetBrains PhpStorm.
 * User: julien
 * Date: 22/04/13
 * Time: 13:09
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Routing;

class EmptyRoutesCollection extends \Exception{};

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
    /**
     * @var bool Si vrai FILO
     */
    protected $stack;
    /**
     * @var bool Si vrai FIFO
     */
    protected $queue;

    public function __construct(){
        $this->routes = new \SplStack();
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
        $this->routes->push($route);
    }

    public function getDefaultRoute() {
        if( $this->routes->count() > 0 ) {
            $this->routes->rewind();
            return $this->routes->offsetGet(0);
        }
        else {
            throw new EmptyRoutesCollection('Please populate RoutesCollection before accessing it.');
        }
    }

    public function reset() {
        $this->routes = new \SplStack();
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

}