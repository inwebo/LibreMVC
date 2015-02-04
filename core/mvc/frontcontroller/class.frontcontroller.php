<?php
namespace LibreMVC\Mvc;

use LibreMVC\ClassNamespace;
use LibreMVC\Http\Request;
use LibreMVC\Mvc\Controller;
use LibreMVC\Routing\Route;
use LibreMVC\View;
use LibreMVC\System;
use LibreMVC\Mvc\Controller\AjaxController;

class DispatcherUnknownController extends \Exception {};
class DispatcherUnknownActionController extends \Exception {};

/**
 * Class Dispatcher (Distributeur)
 *
 * Recoit un objet Http\Request, une routes déjà routée ainsi qu'une vue, le frontcontroller doit permettre
 * l'instaciation de l'ActionController, appel de la methode d'action correspondante avec les bon paramètres.
 *
 * @todo : Devrait gérér les plugins.
 *
 * @package LibreMVC\Mvc
 */

class FrontController {

    const DEFAULT_ACTION = "index";
    const ACTION_SUFFIX = "Action";

    /**
     * @var Request
     */
    protected $_request;
    /**
     * @var Route
     */
    protected $_route;
    /**
     * @var View
     */
    protected $_view;
    /**
     * @var mixed
     */
    protected $_actionController;
    /**
     * @var System
     */
    protected $_system;
    /**
     * @var Route
     */
    protected $_defaultRoute;

    public function __construct( Request $request, System $system ) {
        $this->_request             = $request;
        $this->_system = $system;
        $this->_view    = $this->_system->this()->layout;
        $this->_route               = $this->_system->this()->routed;
        $this->_actionController    = $this->actionControllerFactory();
    }

    /**
     * Doit instancier le controller requis depuis la route courante.
     * @return mixed une instance du controller si il existe sinon null
     * @throws DispatcherUnknownController
     */
    protected function actionControllerFactory() {
        if( $this->isRegistered() ) {
            return new $this->_route->controller( $this->_request, $this->_system );
        }
    }

    /**
     * La classe est elle accessible ?
     * @return bool
     */
    protected function isRegistered() {
        return class_exists( $this->_route->controller, true );
    }

    /**
     * Distribution
     *
     * La distribution doit permettre l'instanciation du controller avec la méthode souhaitée ainsi que les bons arguments.
     *
     * @return mixed
     * @throws DispatcherUnknownActionController Si l'action demandée n'existe pas.
     * @throws DispatcherUnknownController Si le controller n'existe pas
     */
    public function invoker() {
        // Action souhaitée
        $action =  $this->_route->action . self::ACTION_SUFFIX;
        // Le controller est-il une classe déjà connues.
        if( $this->isRegistered() ) {
            // Le controller possede t il la method demandée
            if( method_exists( $this->_actionController, $action ) ) {
                $actionController = new \ReflectionMethod( $this->_actionController, $action );
                return $actionController->invokeArgs(
                    $this->_actionController,
                    $this->_route->params
                );
            }
            // Sinon
            else {
                // Route static
                if(is_callable(array($this->_actionController, $action)) ) {
                    $action = str_replace(self::ACTION_SUFFIX,'',$action);
                    $this->_actionController->$action($this->_route->params);
                }
                else {
                    header('HTTP/1.1 404 Not Found');
                    if($this->gotDefaultRoute()) {
                        $this->_system->routed = $this->_defaultRoute;
                        try {
                            (new self($this->_request,$this->_system))->invoker();
                        }
                        catch(\Exception $e) {
                            throw new DispatcherUnknownActionController( $this->_route->controller .'->'. $action.'() : ' .  ' method doesn\'t exists, and no default route' );
                        }
                    }
                    else {
                        throw new DispatcherUnknownActionController( $this->_route->controller .'->'. $action.'() : ' .  ' method doesn\'t exists !' );
                    }

                }
            }
        }
        // Controller inconnu.
        else {
            throw new DispatcherUnknownController( 'Class : "' . $this->controller .  '" is not registered, register it !' );
        }
    }

    public function getDefaultRoute() {
        return $this->_defaultRoute;
    }

    public function attachDefaultRoute(Route $route){
        $this->_defaultRoute = $route;
    }

    public function gotDefaultRoute() {
        return isset($this->_defaultRoute);
    }
}