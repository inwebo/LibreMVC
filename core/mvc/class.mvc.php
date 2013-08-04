<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 29/04/13
 * Time: 04:53
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC;


class MVC {

    public $class;
    public $method;
    public $parameters;
    protected $registered;

    public function __construct( $class, $method, $parameters ) {
        $this->class      = $class;
        $this->registered = $this->isRegistered();
        $this->method     = $method . 'Action';
        $this->parameters = $parameters;
    }

    protected function isRegistered() {
        return class_exists( $this->class );
    }

    public function exec() {
        // Class disponible.
        if( $this->registered ) {

            // Method exist ET public
            if( method_exists( $this->class, $this->method ) ) {
                $reflectionMethod = new  \ReflectionMethod( $this->class, $this->method );
                //var_dump($this->parameters);
                return $reflectionMethod->invokeArgs(
                    new $this->class,
                    $this->parameters
                );
            }

        }
        else {
            // Exception
            throw new \Exception( $this->class . ' is not registered, include it !' );
        }
    }

    static public function invoker( $class, $method, $parameters ) {
        $handler = new self( $class, $method, $parameters );
        $handler->exec();
    }

}