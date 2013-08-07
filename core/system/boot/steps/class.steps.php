<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 30/04/13
 * Time: 23:07
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\System\Boot;

use LibreMVC\Mvc\Environnement;
use LibreMVC\Instance;
use LibreMVC\Files\Config;
use LibreMVC\Routing\Router;
use LibreMVC\Http\Uri;
use LibreMVC\Routing\RoutesCollection;
use LibreMVC\Routing\UriParser\Asserts;
use LibreMVC\Mvc;
use LibreMVC\Http\Context;

class Steps {

    static public function registerErrorHandler() {
        set_error_handler( '\LibreMVC\Errors\ErrorsHandler::add' );
    }

    static public function includeInstanceAutoloadFile() {
        Environnement::this()->paths = Instance::current()->processPattern(Config::load( "config/paths.ini" ), "", '' );
        Environnement::this()->instance = new Instance( Context::getUrl() );
        if(is_file( Environnement::this()->paths )) {
            include(Environnement::this()->paths['base_autoload'] );
        }
        else {
            //@todo message erreur
        }
    }

    static public function loadRoutes() {}

    /**
     * Devrait être un Object Front controller
     * Applique le pattron de concéption Commande
     */
    static public function frontController() {
        $router = new Router( Uri::current(), RoutesCollection::getRoutes(), Asserts::load() );
        $routedRoute = $router->dispatch();
        // @todo n'est pas peuplé ?
        Environnement::this()->controller  = $routedRoute->controller;
        Environnement::this()->action      = $routedRoute->action;
        Environnement::this()->params      = $routedRoute->params;
        Environnement::this()->routedRoute = $routedRoute;
        //var_dump(Environnement::this());
        Mvc::invoker(
            $routedRoute->controller,
            $routedRoute->action,
            $routedRoute->params
        );



    }

    //@todo Load instance ini
    static public function loadIniFilesFromInstances() {

    }


}