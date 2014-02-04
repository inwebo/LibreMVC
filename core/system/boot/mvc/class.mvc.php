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
use LibreMVC\Http\Header;
use LibreMVC\Http\Request;
use LibreMVC\Web\Instance\Paths;
use LibreMVC\Localisation;
use LibreMVC\Mvc\Environnement;
use LibreMVC\Files\Config;
use LibreMVC\Routing\Router;
use LibreMVC\Http\Uri;
use LibreMVC\Routing\RoutesCollection;
use LibreMVC\Routing\UriParser\Asserts;
use LibreMVC\Http\Context;
use LibreMVC\Sessions;
use LibreMVC\System\Hooks;
use LibreMVC\View\ViewBag;
use LibreMVC\Models\User;
use LibreMVC\Models\Role;
use LibreMVC\Database\Driver\SqLite;
use LibreMVC\Errors\ErrorsHandler;
use LibreMVC\Mvc\Controllers;
use LibreMVC\Mvc\Dispatcher;
use LibreMVC\Files\Directory;

use LibreMVC\Web\Instance;

class Mvc {

    const LIBREMVC_CONFIG_INI = "config/paths.ini";

    public static $config;
    public static $request;
    public static $instance;
    public static $environnement;
    public static $paths = array();

    static public function setErrorHandler() {
        set_error_handler( '\LibreMVC\Errors\ErrorsHandler::add' );
    }

    /**
     * Requête Http courante.
     */
    static public function setRequest() {
        self::$request = Request::current();
    }

    /**
     * Charge le fichier de configuration des chemins de l'application courante.
     */
    static public function setConfig() {
        self::$config = Config::load( self::LIBREMVC_CONFIG_INI, true );
    }

    static public function setEnvironnement() {
        self::$environnement = Environnement::this();
    }

    static public function setInstance() {
        self::$instance = new Instance( Context::getBaseUrl() );
    }

    static public function setLocalisation() {
        Localisation::setup('','','');
    }

    static public function startSession() {
        $sessions_vars = array('lg'=>'fr');
        Hooks::get()->callHooks('addDefaultSessionsVars', $sessions_vars);
        new Sessions();
    }

    static public function sanitizeSuperGlobal() {
        $filterGet = new \LibreMvc\Helpers\Sanitize\SuperGlobal( $_GET );
        $_GET = $filterGet->get();
    }

    static public function processBasePaths() {
        $paths = new Paths(self::$config);

        // Chemins Application
        $basePlaceholders =  array_merge((array)self::$config->Dirs, (array)self::$config->Files, (array)self::$config->DefaultMVC);
        $basePattern = (array)self::$config->Pattern_Global;
        self::$paths['base'] = $paths->processBasePath($basePlaceholders,$basePattern);

        // Chemins Instance
        $instancePlaceholders = array_merge($basePlaceholders, array("%instance%"=>self::$instance->getDir()."/"));
        $instacePattern = (array)self::$config->Pattern_Instance;
        self::$paths['instance'] = $paths->processBasePath($instancePlaceholders,$instacePattern);

        // Chemins Theme
        $dir = new Directory( self::$paths['instance']->instance_themes );
        $dir->folders->rewind();
        $themeName = $dir->folders->current()->name;
        $themePlaceholders =  array_merge(
            (array)self::$config->Dirs,
            (array)self::$config->Files,
            (array)self::$config->Themes,
            array(
                "%theme_current%"   => $themeName . "/",
                "%realPath%"        => self::$instance->getRealPath() . '/'
            )
        );
        $themePattern = (array)self::$config->Themes;
        self::$paths['theme'] = $paths->processBasePath($themePlaceholders,$themePattern);
        //var_dump(self::$paths);
    }

    static public function autoloadInstance() {
        if( is_file( self::$paths['instance']->instance_autoload ) ) {
            include( self::$paths['instance']->instance_autoload );
        }
    }

    static public function autoloadInstanceModules() {
        $dir = new Directory( self::$paths['instance']->instance_modules );
        $dir->folders->rewind();
        while( $dir->folders->valid() ) {

            // @warning : Le dossier contenant les plugins doit avoir +x !
            if(is_file($dir->folders->current()->realPath . '/autoload.php')) {
                include($dir->folders->current()->realPath . '/autoload.php');
            }
            if(is_file($dir->folders->current()->realPath . '/module.ini')) {
                $currentValue = $dir->folders->current()->realPath . '/module.ini';
                $currentKey = ucfirst($dir->folders->current()->name);

                Environnement::this()->Modules = new \StdClass;
                Environnement::this()->Modules->$currentKey = new \StdClass;
                Environnement::this()->Modules->$currentKey->config = $dir->folders->current() . "/module.ini";
            }
            $dir->folders->next();
        }
    }

    static public function initDatabaseEngine() {
        Database\Provider::add('system', new SQlite( self::$paths['instance']->instance_db ) );
    }

    static public function initAuthSystem(){

        Role::binder( Database\Provider::get( 'system' ), 'Roles', 'id' );
        User::binder( Database\Provider::get( 'system' ), 'Users', 'id' );

        if( is_null(Sessions::get('User')) ) {
            $user = \LibreMVC\Models\User::load(0);
            Sessions::set('User', $user);
        }
    }

    static public function lockEnvironnement() {
        self::$environnement->readOnly = true;
    }

    static public function frontController() {
        $router = new Router( self::$instance->getUri(),RoutesCollection::get('default')->getRoutes(), '\\LibreMVC\\Routing\\UriParser\\RouteConstraint' );
        $routedRoute = $router->dispatch();
        self::$paths['mvc'] = array($routedRoute->controller, $routedRoute->action);

        // Vue

        // Dispatcher qui invoke le bon controller

    }

/*



    static public function frontController() {

        $router = new Router( Uri::current(), RoutesCollection::get('default')->getRoutes(), '\\LibreMVC\\Routing\\UriParser\\RouteConstraint' );

        $routedRoute = $router->dispatch();

        // Est ce une route valide ?
        if( $routedRoute !== false ) {
            Environnement::this()->controller  = $routedRoute->controller;
            Environnement::this()->action      = $routedRoute->action;
            Environnement::this()->params      = $routedRoute->params;
            Environnement::this()->routedRoute = $routedRoute;

            Dispatcher::invoker(
                $routedRoute->controller,
                $routedRoute->action,
                $routedRoute->params
            );

        }
        // Erreur 404
        else {
            $ex = __FILE__ . ' line : ' . __LINE__ . ' : ';
            //Controllers\ErrorsController::throwHttpError('404');
            Header::error(503);
            throw new \Exception($ex . 'nknow route !');
        }

    }

    static public function postRender() {

    }

*/
}