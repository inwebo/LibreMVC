<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 13/10/13
 * Time: 11:12
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\System\Boot\Cli;
use LibreMVC\Database;
use LibreMVC\Files\Directory;
use LibreMVC\Helpers\BreadCrumbs;
use LibreMVC\Html\Helpers\Theme;
use LibreMVC\Localisation;
use LibreMVC\Mvc\Environnement;
use LibreMVC\Instance;
use LibreMVC\Files\Config;
use LibreMVC\Routing\Router;
use LibreMVC\Http\Uri;
use LibreMVC\Routing\RoutesCollection;
use LibreMVC\Routing\UriParser\Asserts;
use LibreMVC\Http\Context;
use LibreMVC\Sessions;
use LibreMVC\System\Hooks;
use LibreMVC\Views\Template\ViewBag;
use LibreMVC\Routing\Route;
use LibreMVC\Models\User;
use LibreMVC\Models\Role;
use LibreMVC\Database\Driver\SqLite;

class Cli {

    static public function registerEnvironnement() {
        Environnement::this()->server = Context::getServer(true,true);
    }

    static public function registerErrorHandler() {
        set_error_handler( '\LibreMVC\Errors\ErrorsHandler::add' );
    }

    static public function autoloadInstance() {
        Environnement::this()->paths = Instance::current()->processPattern(Config::load( "config/paths.ini" ), "", '' );
        Environnement::this()->instance = new Instance( Context::getUrl() );

        Environnement::this()->baseUrls = Environnement::this()->instance->processBaseIncludePattern( Environnement::this()->instance->baseUrl, Environnement::this()->paths );

        if(is_file( Environnement::this()->paths->base_autoload )) {
            include(Environnement::this()->paths->base_autoload );
        }
    }

    static public function autoloadPlugins() {
        $dir = new Directory( Environnement::this()->paths->base_modules );
        $dir->folders->rewind();
        while($dir->folders->valid()) {
            if(is_file($dir->folders->current()->realPath . '/autoload.php')) {
                include($dir->folders->current()->realPath . '/autoload.php');
            }
            if(is_file($dir->folders->current()->realPath . '/module.ini')) {
                $currentValue = $dir->folders->current()->realPath . '/module.ini';
                $currentKey = ucfirst($dir->folders->current()->name);
                Environnement::this()->Modules = null;
                Environnement::this()->Modules->$currentKey->config = $dir->folders->current() . "/module.ini";
            }
            $dir->folders->next();
        }
    }

    static public function loadSystemDb() {
        Database\Provider::add('system', new SQlite(Environnement::this()->paths->base_routes));
        Environnement::this()->_dbSystem = Database\Provider::get('system');
    }

    static public function localisation() {
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

    /**
     * Devrait être un Object Front controller
     * Applique le pattron de concéption Commande
     */
    static public function frontController() {
        //var_dump(RoutesCollection::getRoutes());
        // Lock du singleton en lecture seule
        Environnement::this()->readOnly = true;

        $router = new Router( Uri::current(), RoutesCollection::getRoutes(), Asserts::load() );

        $routedRoute = $router->dispatch();
        Environnement::this()->controller  = $routedRoute->controller;
        Environnement::this()->action      = $routedRoute->action;
        Environnement::this()->params      = $routedRoute->params;
        Environnement::this()->routedRoute = $routedRoute;

        \LibreMVC\Dispatcher::invoker(
            $routedRoute->controller,
            $routedRoute->action,
            $routedRoute->params
        );

    }

}