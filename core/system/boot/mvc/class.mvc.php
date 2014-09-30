<?php

namespace LibreMVC\System\Boot;

use LibreMVC\Database;
use LibreMVC\Helpers\NameSpaces;
use LibreMVC\Html\Helpers\Theme;
use LibreMVC\Http\Request;
use LibreMVC\Http\Uri;
use LibreMVC\Helpers\Sanitize\SuperGlobal;
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
     * Will the application display a var_dump of each steps.
     */
    const DEBUG = false;

    /**
     * System ini file's path.
     */
    const PATHS_CONFIG_FILE     = "config/paths.ini";
    const DEFAULT_CONFIG_FILE   = "config/config.ini";

    const AUTOLOAD_FILE_PATH = "/autoload.php";

    const CONFIG_DEFAULT_FILE_PATH = "/config.ini";

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
        if(Mvc::DEBUG) {
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

    static public function initConfig() {
        self::$config = new \StdClass();
    }

    /**
     * Configuration des chemins.
     */
    static public function configPaths() {
        if( is_file( self::PATHS_CONFIG_FILE ) ) {
            self::$config->paths = Config::load( self::PATHS_CONFIG_FILE, true );
        }
        MVC::debug(self::$config);
    }

    /**
     * Configuration des chemins.
     */
    static public function autoloadConfig() {
        if( is_file( self::PATHS_CONFIG_FILE ) ) {
            self::$config->paths = Config::load( self::PATHS_CONFIG_FILE, true );
        }
        MVC::debug(self::$config);
    }

    static public function setEnvironnement() {
        self::$environnement = Environnement::this();
        self::$environnement->urls = new \StdClass();
        MVC::debug(self::$environnement);
    }

    static public function setInstance() {
        self::$instance = new Instance( Context::getBaseUrl() );
        self::$environnement->instance = self::$instance;
        //var_dump(self::$instance);
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
        $filterGet = new SuperGlobal( $_GET );
        $_GET = $filterGet->get();
    }

    static public function processBasePaths() {
        self::$pathsProcessor = new Paths(self::$config);

        // Chemins Application
        $basePlaceholders =  array_merge((array)self::$config->paths->Dirs, (array)self::$config->paths->Files, (array)self::$config->paths->DefaultMVC);
        $basePattern = (array)self::$config->paths->Pattern_Global;
        self::$paths['base'] = self::$pathsProcessor->processBasePath($basePlaceholders,$basePattern);

        // Chemins Instance
        $instancePlaceholders = array_merge($basePlaceholders, array("%instance%"=>self::$instance->getDir()."/"));
        $instancePattern = (array)self::$config->paths->Pattern_Instance;
        self::$paths['instance'] = self::$pathsProcessor->processBasePath($instancePlaceholders,$instancePattern);

        // Chemins Theme
        $dir = new Directory( self::$paths['instance']->instance_themes );

        $themePattern = (array)self::$config->paths->Themes;
        self::$paths['themes'] = array();

        // Parcours tous les themes
        foreach($dir->folders as $inode) {
            $themePlaceholders =  array_merge(
                (array)self::$config->paths->Dirs,
                (array)self::$config->paths->Files,
                (array)self::$config->paths->Themes,
                array(
                    "%theme_current%"   => $inode->name .'/' ,
                    "%realPath%"        => self::$instance->getRealPath() . '/',
                    "%baseUrl%"         => Context::getBaseUrl()
                )
            );

            self::$paths['themes'][$inode->name] = self::$pathsProcessor->processBasePath($themePlaceholders,$themePattern);

        }
        self::$environnement->basePaths =self::$paths['base'];
        self::$environnement->themes =self::$paths['themes'];
        Mvc::debug(self::$paths);
        //var_dump(self::$paths);
    }

    static public function autoloadInstanceConfig() {
        $config = self::$paths['instance']->instance_config_file;
        if( is_file( $config ) )  {
            self::$config->instance = Config::load($config);
        }
    }

    static public function autoloadInstance() {
        if( is_file( self::$paths['instance']->instance_autoload ) ) {
            include( self::$paths['instance']->instance_autoload );
        }
    }

    static public function initModulesConfig(){
        self::$config->config->modules = new \StdClass();
    }

    /**
     * Autoload module file & config.ini
     */
    static public function autoloadModulesConfig() {
        $dir = new Directory( self::$paths['instance']->instance_modules );
        $dir->folders->rewind();
        while( $dir->folders->valid() ) {

            // @warning : Le dossier contenant les plugins doit avoir +x !
            if(is_file($dir->folders->current()->realPath .  Mvc::AUTOLOAD_FILE_PATH)) {
                include($dir->folders->current()->realPath . Mvc::AUTOLOAD_FILE_PATH);
            }

            if( is_file( $dir->folders->current()->realPath . Mvc::CONFIG_DEFAULT_FILE_PATH ) ) {
                $configFile = $dir->folders->current()->realPath . Mvc::CONFIG_DEFAULT_FILE_PATH;
                $currentKey = ucfirst($dir->folders->current()->name);
                self::$config->modules->$currentKey = Config::load( $configFile );
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
         //var_dump($_SESSION);
    }

    static public function router() {
        // Get Route
        $router = new Router( Uri::current() ,RoutesCollection::get('default')->getRoutes(), '\\LibreMVC\\Routing\\UriParser\\RouteConstraint' );
        self::$routedRoute = $routedRoute = $router->dispatch();
        self::$environnement->route = $routedRoute;

        //var_dump(self::$config->paths->DefaultMVC);

        //var_dump($routedRoute);

        // Prepare mvc config
        $mvcPlaceHolders =  array_merge(
            (array)self::$config->paths->Dirs,
            (array)self::$config->paths->Files,
            (array)self::$config->paths->Themes,
            (array)self::$config->paths->DefaultMVC,
            array(
                "%controller%"  => NameSpaces::getControllerSuffixedName($routedRoute->controller),
                "%action%"      => $routedRoute->action,
                "%instance%"    => self::$instance->getDir() . "/"
            )
        );

        // Est ce un controller static càd Est ce que le params['staticFile'] est setter ?


        if(isset($routedRoute->params['staticFile'])) {
            self::$config->paths->MVC->mvc_view = self::$config->paths->Pattern_Instance->instance_static . '' . $routedRoute->params['staticFile'] . '.php';
        }


        // Process paths
        self::$paths['mvc'] = self::$pathsProcessor->processBasePath(
            $mvcPlaceHolders,
            self::$config->paths->MVC
        );

        Mvc::debug(self::$paths);
    }

    static public function processHttpPaths() {
        $httpPaths = (array)self::$paths['instance'];
        array_walk($httpPaths,function(&$item){
            $item = Context::getBaseUrl() . $item;
        });
        self::$paths['http'] = $httpPaths;
        self::$environnement->urls->instance = $httpPaths;

        Mvc::debug(self::$paths);

    }

    static public function autoloadThemes() {
        // Pour chaques themes un nouvel objet theme.
        $themes = new \StdClass();
        $css = array();
        $js = array();
        foreach(self::$paths['themes'] as $k => $v) {
            $themes->$k = new Theme(Config::load($v->theme_config_file,true), $v);
            $css= array_merge($themes->$k->getHref(),$css);
            $js= array_merge($themes->$k->getSrc(),$js);
        }
        //
        Environnement::this()->css = $css;
        Environnement::this()->js = $js;
        //var_dump($js);
        Mvc::debug($themes);
    }

    static public function viewObjectFactory() {
        $vo = new View\ViewObject();
        Environnement::this()->templateAction = self::$paths['mvc']->mvc_view;
        //$vo->body = self::$paths['mvc']->mvc_view;
        self::$viewObject = $vo;
        Mvc::debug(self::$viewObject);
    }

    static public function configToEnv() {
        Environnement::this()->config = self::$config;
    }

    static public function lockEnvironnement() {
        self::$environnement->readOnly(true);
        Mvc::debug(self::$environnement);
    }

    static public function frontController() {
        //var_dump(self::$environnement);
        try {

            // @todo : Static view path.
            // Static view ?
            // var_dump(self::$paths);
            // Layout du site

            try {
                $template = new View\Template( self::$paths['mvc']->mvc_layout );
                $view = new View($template, self::$viewObject);
            }
            catch(\Exception $e) {
                // Le template demandé n'existe pas.
                var_dump($e);
            }
        }
        catch(\Exception $e) {
            // Le template demandé n'existe pas.
            var_dump($e);
        }

        // Dispatcher qui invoke le bon controller
        try {
            $dispatcher = new Dispatcher( self::$request, self::$routedRoute, $view );
            // Auto render de la vue.
            $dispatcher->dispatch();
        }
        catch(\Extepion $e) {
            var_dump($e);
        }

    }

}