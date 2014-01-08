<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 29/04/13
 * Time: 04:53
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Mvc;

use LibreMVC\ClassNamespace;
use LibreMVC\Mvc\Environnement;

class DispatcherUnknownController extends \Exception {};
class DispatcherUnknownActionController extends \Exception {};

class Dispatcher {

    public $class;
    public $method;
    public $parameters;

    public function __construct( $class, $method, $parameters ) {
        $this->class      = $class;
        $this->method     = $method . 'Action';
        $this->parameters = $parameters;
    }

    protected function isRegistered() {
        return class_exists( $this->class, true );
    }

    /**
     * @return mixed
     * @throws mixed
     */
    public function dispatch() {
        // Le controller est-il une classe déjà connues.
        if( $this->isRegistered() ) {

            $this->parameters = ( is_null( $this->parameters)) ? array() : $this->parameters;
            // Le controller possede t il la method demandée
            if( method_exists( $this->class, $this->method ) ) {

                $reflectionMethod = new  \ReflectionMethod( $this->class, $this->method );
                return $reflectionMethod->invokeArgs(
                    new $this->class,
                    $this->parameters
                );
            }
            // Sinon
            else {
                // @todo Error controller
                //ErrorsController::throwHttpError('404');
                throw new DispatcherUnknownActionController( $this->class .'->'. $this->method.'() : ' .  ' is not a method !' );
            }

        }
        // Class inconnue.
        else {
            //ErrorsController::throwHttpError('404');
            throw new DispatcherUnknownController( $this->class .  ' is not registered, register it !' );
        }
    }

    static public function invoker( $class, $method, $parameters ) {
        $handler = new self( $class, $method, $parameters );
        $handler->dispatch();
    }

}