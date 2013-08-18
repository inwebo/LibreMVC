<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 30/04/13
 * Time: 23:07
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\System\Boot;

use LibreMVC\Database;
use LibreMVC\Files\Directory;
use LibreMVC\Localisation;
use LibreMVC\Mvc\Environnement;
use LibreMVC\Instance;
use LibreMVC\Files\Config;
use LibreMVC\Routing\Router;
use LibreMVC\Http\Uri;
use LibreMVC\Routing\RoutesCollection;
use LibreMVC\Routing\UriParser\Asserts;
use LibreMVC\Mvc;
use LibreMVC\Http\Context;
use LibreMVC\Sessions;
use LibreMVC\System\Hooks;
use LibreMVC\Views\Template\ViewBag;
use LibreMVC\Database\Driver\SQlite;
use LibreMVC\Routing\Route;
use LibreMVC\Cache;
class Steps {

    static public function registerEnvironnement() {
        Environnement::this()->server = Context::getServer(true,true);
    }

    static public function registerErrorHandler() {
        set_error_handler( '\LibreMVC\Errors\ErrorsHandler::add' );
    }

    static public function includeInstanceAutoloadFile() {
        Environnement::this()->paths = Instance::current()->processPattern(Config::load( "config/paths.ini" ), "", '' );
        Environnement::this()->instance = new Instance( Context::getUrl() );
        if(is_file( Environnement::this()->paths['base_autoload'] )) {
            include(Environnement::this()->paths['base_autoload'] );
        }
    }

    static public function autoloadPlugins() {
        $dir = new Directory( Environnement::this()->paths['base_modules'] );
        $dir->folders->rewind();
        while($dir->folders->valid()) {
            if(is_file($dir->folders->current()->realPath . '/autoload.php')) {
                include($dir->folders->current()->realPath . '/autoload.php');
            }
            $dir->folders->next();
        }
    }

    static public function loadSystemDb() {
        Environnement::this()->_dbSystem = Database::setup('system', new SQlite(Environnement::this()->paths['base_routes']));
        Environnement::this()->_dbSystem = Database::get('system');
    }

    static public function local() {
        Localisation::setup('','','');
    }

    static public function defaultRoute() {

        Hooks::get()->callHooks('prependRoutes');
        // Default route
        //@todo bug sur les routes nommées le chemin base_view n'est pas construit
        $defaultRoute = new Route();
        $defaultRoute->name = "";
        $defaultRoute->pattern = trim(Environnement::this()->instance->baseUri,'/').'[/][:action][/][:id][/]';
        $defaultRoute->controller = '\LibreMVC\Controllers\HomeController';
        $defaultRoute->action = 'index';
        RoutesCollection::addRoute($defaultRoute);
        Hooks::get()->callHooks('appendRoutes');
    }

    static public function startSession() {
        $sessions_vars = array('lg'=>'fr');
        Hooks::get()->callHooks('addDefaultSessionsVars', $sessions_vars);
        new Sessions(null, $sessions_vars[1]);
        //echo(new Sessions(null, $sessions_vars[1]));
    }

    static public function preRender() {
        try {

        }
        catch(\Exception $e) {

        }

    }

    static public function loadThemes() {
        $css = array();
        $js = array();
        Hooks::get()->callHooks('loadThemes');
        // 1 - Parser Config
        $config = Config::load(Environnement::this()->paths['base_themes']."default/theme.ini");
        // 2 - Peupler l'includer

    }

    /**
     * Devrait être un Object Front controller
     * Applique le pattron de concéption Commande
     */
    static public function frontController() {
        //var_dump(RoutesCollection::getRoutes());
        $router = new Router( Uri::current(), RoutesCollection::getRoutes(), Asserts::load() );

        $routedRoute = $router->dispatch();
        Environnement::this()->controller  = $routedRoute->controller;
        Environnement::this()->action      = $routedRoute->action;
        Environnement::this()->params      = $routedRoute->params;
        Environnement::this()->routedRoute = $routedRoute;

        Mvc::invoker(
            $routedRoute->controller,
            $routedRoute->action,
            $routedRoute->params
        );

    }

    static public function postRender() {

    }


}