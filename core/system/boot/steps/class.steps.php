<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 30/04/13
 * Time: 23:07
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\System\Boot;


class Steps {

    static public function registerErrorHandler() {
        set_error_handler( '\LibreMVC\Errors\ErrorsHandler::add' );
    }

    static public function includeInstanceAutoloadFile() {
        $instance = new \LibreMVC\Instance( \LibreMVC\Http\Context::getUrl() );
        $paths = $instance->processPattern( \LibreMVC\Files\Config::load( "config/paths.ini" ), "home", 'index' );
        \LibreMVC\AutoLoader::getAutoload( $paths['base_autoload'] );
    }

    static public function routerDispatch() {



        $router = new \LibreMCV\Routing\Router( \LibreMCV\Http\Uri::current(), \LibreMCV\Routing\RoutesCollection::getRoutes(), \LibreMCV\Routing\UriParser\Asserts::load() );
        $routedRoute = $router->dispatch();

        //var_dump($routedRoute);


        \LibreMCV\Mvc::invoker(
            $routedRoute->controller,
            $routedRoute->action,
            $routedRoute->params
        );
    }

    /**
     * Front controller
     */
    static public function startFrontController() {

    }

}