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

    static public function routerDispatch() {
        // 1 - Recuperation de toutes les routes

        //
    }

    static public function includeInstanceAutoloadFile() {
        $instance = new \LibreMVC\Instance( \LibreMVC\Http\Context::getUrl() );
        $paths = $instance->processPattern( \LibreMVC\Files\Config::load( "config/paths.ini" ), "home", 'index' );
        \LibreMVC\AutoLoader::getAutoload( $paths['base_autoload'] );
    }

}