<?php

namespace LibreMVC\System\Boot;

use LibreMVC\Database;
use LibreMVC\Helpers\NameSpaces;
use LibreMVC\Html\Helpers\Theme;
use LibreMVC\Http\Request;
use LibreMVC\Http\Uri;
use LibreMVC\Routing\Route;
use LibreMVC\Web\Instance\Paths;
use LibreMVC\Localisation;
use LibreMVC\Mvc\Environnement;
use LibreMVC\Files\Config;
use LibreMVC\Routing\Router;
use LibreMVC\Routing\RoutesCollection;
use LibreMVC\Routing\UriParser\Asserts;
use LibreMVC\Http\Context;
use LibreMVC\Sessions;
use LibreMVC\System\Hooks;
use LibreMVC\View;
use LibreMVC\Models\User;
use LibreMVC\Models\Role;
use LibreMVC\Database\Driver\SqLite;
use LibreMVC\Mvc\Controllers;
use LibreMVC\Mvc\Dispatcher;
use LibreMVC\Files\Directory;
use LibreMVC\Web\Instance;

/**
 * Class Mvc
 *
 * Application boot strap, each static public methods will be call.
 *
 * @package LibreMVC\System\Boot
 */
class Mvc {

    /**
     * System ini file's path.
     */
    const LIBREMVC_CONFIG_INI = "config/paths.ini";

    /**
     * Will the application display a var_dump of each steps.
     */
    const LIBREMVC_MVC_DEBUG = false;

    const LIBREMVC_AUTOLOAD_FILE_PATH = "/autoload.php";
    const LIBREMVC_MODULE_FILE_PATH = "/module.ini";

    /**
     * @var Config object from LIBREMVC_CONFIG_INI.
     */
    public static $config;

    /**
     * @var Current HTTP request.
     */
    public static $request;

    /**
     * @var Current instance paths.
     */
    public static $instance;
    public static $environnement;
    public static $paths = array();
    public static $pathsProcessor;
    public static $routedRoute;
    public static $viewObject;

    static private function debug($var) {
        if(Mvc::LIBREMVC_MVC_DEBUG) {
            var_dump($var);
        }
    }

    static public function setErrorHandler() {
        set_error_handler( '\LibreMVC\Errors\ErrorsHandler::add' );
    }

    /**
     * Requête Http courante.
     */
    static public function setRequest() {
        self::$request = Request::current();
        MVC::debug(self::$request);
    }

    /**
     * Charge le fichier de configuration des chemins de l'application courante.
     */
    static public function setConfig() {
        self::$config = Config::load( self::LIBREMVC_CONFIG_INI, true );
        MVC::debug(self::$config);
    }

    static public function setEnvironnement() {
        self::$environnement = Environnement::this();
        MVC::debug(self::$environnement);
    }

    static public function setInstance() {
        self::$instance = new Instance( Context::getBaseUrl() );
        MVC::debug(self::$instance);
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
        self::$pathsProcessor = new Paths(self::$config);

        // Chemins Application
        $basePlaceholders =  array_merge((array)self::$config->Dirs, (array)self::$config->Files, (array)self::$config->DefaultMVC);
        $basePattern = (array)self::$config->Pattern_Global;
        self::$paths['base'] = self::$pathsProcessor->processBasePath($basePlaceholders,$basePattern);

        // Chemins Instance
        $instancePlaceholders = array_merge($basePlaceholders, array("%instance%"=>self::$instance->getDir()."/"));
        $instancePattern = (array)self::$config->Pattern_Instance;
        self::$paths['instance'] = self::$pathsProcessor->processBasePath($instancePlaceholders,$instancePattern);

        // Chemins Theme
        $dir = new Directory( self::$paths['instance']->instance_themes );

        $themePattern = (array)self::$config->Themes;
        self::$paths['themes'] = array();

        // Parcours tous les themes
        foreach($dir->folders as $inode) {
            $themePlaceholders =  array_merge(
                (array)self::$config->Dirs,
                (array)self::$config->Files,
                (array)self::$config->Themes,
                array(
                    "%theme_current%"   => $inode->name .'/' ,
                    "%realPath%"        => self::$instance->getRealPath() . '/',
                    "%baseUrl%"         => Context::getBaseUrl()
                )
            );

            self::$paths['themes'][$inode->name] = self::$pathsProcessor->processBasePath($themePlaceholders,$themePattern);

        }
        Mvc::debug(self::$paths);
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
            if(is_file($dir->folders->current()->realPath .  Mvc::LIBREMVC_AUTOLOAD_FILE_PATH)) {
                include($dir->folders->current()->realPath . Mvc::LIBREMVC_AUTOLOAD_FILE_PATH);
            }
            if(is_file($dir->folders->current()->realPath . Mvc::LIBREMVC_MODULE_FILE_PATH)) {
                $currentValue = $dir->folders->current()->realPath . Mvc::LIBREMVC_MODULE_FILE_PATH;
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
        var_dump($_SESSION);
    }

    static public function setAdminRoute() {
        $adminRoute = new Route(
           '/' . self::$instance->getBaseUri().'admin[/]',
            '\LibreMVC\Controllers\HomeController',
            'login'
        );
        RoutesCollection::get('default')->addRoute($adminRoute);
        //var_dump($adminRoute);
    }

    static public function router() {
        // Get Route
        $router = new Router( Uri::current() ,RoutesCollection::get('default')->getRoutes(), '\\LibreMVC\\Routing\\UriParser\\RouteConstraint' );
        self::$routedRoute = $routedRoute = $router->dispatch();

        // Prepare mvc config
        $mvcPlaceHolders =  array_merge(
            (array)self::$config->Dirs,
            (array)self::$config->Files,
            (array)self::$config->Themes,
            (array)self::$config->DefaultMVC,
            array(
                "%controller%"  => NameSpaces::getControllerSuffixedName($routedRoute->controller),
                "%action%"      => $routedRoute->action,
                "%instance%"    => self::$instance->getDir()."/"
            )
        );
        // Process paths
        self::$paths['mvc'] = self::$pathsProcessor->processBasePath(
            $mvcPlaceHolders,
            self::$config->MVC
        );
        Mvc::debug(self::$paths);
        //var_dump(self::$paths);
    }

    static public function processHttpPaths() {
        $httpPaths = (array)self::$paths['instance'];
        array_walk($httpPaths,function(&$item){
            $item = Context::getBaseUrl() . $item;
        });
        self::$paths['http']=$httpPaths;
        Mvc::debug(self::$paths);
    }

    static public function autoloadThemes() {
        // Pour chaques themes un nouvel objet theme.
        $themes = new \StdClass();
        foreach(self::$paths['themes'] as $k => $v) {
            $themes->$k = new Theme(Config::load($v->theme_realPath_ini,true), $v);
        }
        //var_dump($themes);
        Mvc::debug($themes);
    }

    static public function viewObjectFactory() {
        $vo = new View\ViewObject();
        Environnement::this()->templateAction = self::$paths['mvc']->mvc_view;
        //$vo->body = self::$paths['mvc']->mvc_view;
        self::$viewObject = $vo;
        Mvc::debug(self::$viewObject);
    }

    static public function lockEnvironnement() {
        self::$environnement->readOnly(true);
        Mvc::debug(self::$environnement);
    }

    static public function frontController() {
        // Vue
        $view = new View(new View\Template(self::$paths['mvc']->mvc_layout), self::$viewObject);
        // Dispatcher qui invoke le bon controller
        $dispatcher = new Dispatcher( self::$request, self::$routedRoute, $view );
        // Auto render de la vue.
        $dispatcher->dispatch();
    }

}