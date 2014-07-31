<?php
namespace LibreMVC\Mvc;

use LibreMVC\ClassNamespace;
use LibreMVC\Http\Request;
use LibreMVC\Mvc\Controller;
use LibreMVC\Mvc\Environnement;
use LibreMVC\Routing\Route;
use LibreMVC\View;

class DispatcherUnknownController extends \Exception {};
class DispatcherUnknownActionController extends \Exception {};

/**
 * Class Dispatcher (Distributeur)
 *
 * Recoit un objet Http\Request, une routes déjà routée ainsi qu'une vue, le dispatcher doit permettre
 * l'instaciation de l'ActionController, appel de la methode d'action correspondante avec les bon paramètres.
 *
 * @package LibreMVC\Mvc
 */

class Dispatcher {
    const ACTION_SUFFIX = "Action";
    /**
     * @var \LibreMVC\Http\Request
     */
    protected $_request;
    /**
     * @var \LibreMVC\Routing\Route
     */
    protected $_route;
    /**
     * @var \LibreMVC\View
     */
    protected $_view;
    /**
     * @var mixed
     */
    protected $_actionController;

    /**
     * @param Request $request Une requête HTTP.
     * @param Route $route Une route.
     * @param View $view Une vue a passer à l'action du controller.
     */
    public function __construct( Request $request, Route $route, View $view ) {
        $this->_request             = $request;
        $this->_route               = $route;
        $this->_view                = $view;
        $this->_actionController    = $this->actionControllerFactory();
    }

    /**
     * Doit instancier le controller requis depuis la route courante.
     * @return mixed une instance du controller si il existe sinon null
     * @throws DispatcherUnknownController
     */
    protected function actionControllerFactory() {
        if( $this->isRegistered() ) {
            return new $this->_route->controller( $this->_request, $this->_view );
        }
        else {
            ob_start();
            var_dump($this);
            $msg=ob_get_contents();
            ob_get_clean();
            throw new DispatcherUnknownController("Unknown controller " . $msg);
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
     * @todo : Un controller par default ?
     * @todo : Destruction de l'instance de référence ?
     */
    public function dispatch() {
        // Action souhaitée
        $action =  $this->_route->action . Dispatcher::ACTION_SUFFIX;
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
                throw new DispatcherUnknownActionController( $this->_route->controller .'->'. $action.'() : ' .  ' method doesn\'t exists !' );
            }
        }
        // Controller inconnu.
        else {
            throw new DispatcherUnknownController( $this->controller .  ' is not registered, register it !' );
        }
    }

}