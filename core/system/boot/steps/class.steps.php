<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 30/04/13
 * Time: 23:07
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\System\Boot;
use LibreMVC\Mvc\Environnement as Env;

class Steps {

    static public function registerErrorHandler() {
        set_error_handler( '\LibreMVC\Errors\ErrorsHandler::add' );
    }

    static public function includeInstanceAutoloadFile() {
        $paths = \LibreMVC\Instance::current()->processPattern( \LibreMVC\Files\Config::load( "config/paths.ini" ), "", '' );
        include( $paths['base_autoload'] );
    }

    /**
     * Devrait être un Object Front controller
     * Applique le pattron de concéption Commande
     */
    static public function routerDispatch() {
        $router = new \LibreMVC\Routing\Router( \LibreMVC\Http\Uri::current(), \LibreMVC\Routing\RoutesCollection::getRoutes(), \LibreMVC\Routing\UriParser\Asserts::load() );
        $routedRoute = $router->dispatch();
            \LibreMVC\Mvc::invoker(
            $routedRoute->controller,
            $routedRoute->action,
            $routedRoute->params
        );
        Env::get()->route = $routedRoute->pattern;
        Env::get()->controller = $routedRoute->controller;
        Env::get()->action = $routedRoute->action;
        Env::get()->params = $routedRoute->params;
    }


}