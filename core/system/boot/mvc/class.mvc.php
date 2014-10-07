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

    const DEFAULT_FILE_EXTENSION = '.php';

    /**
     * Framework paths pattern.
     *
     * Contains token, values.
     * Step self::processBasePaths() will injects data from current context  & remplace some values.
     */
    const PATHS_CONFIG_FILE     = "config/paths.ini";

    /**
     * Global config. Always available.
     */
    const DEFAULT_CONFIG_FILE   = "config/config.ini";

    /**
     * @var \StdClass Collection config. -> BasePathsPatterns
     */
    public static $config;

    /**
     * @var \LibreMVC\Http\Request Current HTTP header.
     */
    public static $request;

    /**
     * @var \LibreMVC\Web\Instance Current instance.
     */
    public static $instance;

    /**
     * @var \LibreMVC\System\Singleton Register available into the view.
     */
    public static $environnement;

    /**
     * @var array
     */
    public static $paths = array();

    /**
     * @var
     */
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
    static public function autoloadConfigFramework() {
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
        self::$pathsProcessor = new Paths( self::$config );
        self::$environnement->Files = new \StdClass();

        // Base framework paths
        $basePlaceholders =  array_merge(   (array) self::$config->paths->Dirs,
                                            (array) self::$config->paths->Files,
                                            (array) self::$config->paths->DefaultMVC
                                        );

        $basePattern = (array) self::$config->paths->Pattern_Global;

        $paths = self::$paths['base'] = self::$pathsProcessor->processBasePath( $basePlaceholders, $basePattern );

        // Inject base url base real path for root folder
        $baseUrls = array("relative"=>array(),"url"=>array(),"realpath"=>array());
        foreach($paths as $k => $v) {
            $baseUrls['url'][$k] = Context::getBaseUrl().$v;
            if( is_dir( getcwd() . "/" . $v ) ) {
                $baseUrls['realpath'][$k] = getcwd()."/".$v;
            }
            $baseUrls['relative'][$k] = $v;
        }
        self::$environnement->Files->core = $baseUrls;
        //var_dump($baseUrls);

        // Current instance paths, inject token %instance%
        $instancePlaceholders = array_merge(    $basePlaceholders,
                                                array( "%instance%" => self::$instance->getDir() . "/" )
                                            );

        $instancePattern = (array)self::$config->paths->Pattern_Instance;
        self::$paths['instance'] = self::$pathsProcessor->processBasePath($instancePlaceholders,$instancePattern);
        // Inject base url base real path
        $baseUrls = array("relative"=>array(),"url"=>array(),"realpath"=>array());
        foreach(self::$paths['instance'] as $k => $v) {
            $baseUrls['url'][$k] = Context::getBaseUrl().$v;
            if( is_dir( getcwd() . "/" . $v ) ) {
                $baseUrls['realpath'][$k] = getcwd()."/".$v;
            }
            $baseUrls['relative'][$k] = $v;
        }
        self::$environnement->Files->instance = $baseUrls;
        //var_dump($baseUrls);


        // Current theme paths, inject token %theme_current%, %realPath%, %baseUrl%;
        $dir = new Directory( self::$paths['instance']->instance_themes );

        $themePattern = (array)self::$config->paths->Themes;
        self::$paths['themes'] = array();

        $baseUrls = array("relative"=>array(),"url"=>array(),"realpath"=>array());
        Environnement::this()->Files->Themes = array();
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

            self::$paths['themes'][$inode->name] = self::$pathsProcessor->processBasePath( $themePlaceholders, $themePattern );
            //var_dump(self::$paths['themes']);
            //var_dump(self::$environnement->this()->Files->Themes->$inode->name = self::$paths['themes'][$inode->name]);
            //var_dump($inode->name);
            Environnement::this()->Files->Themes[$inode->name]['url'] = array(
                "base" => self::$paths['themes'][$inode->name]->theme_baseUrl,
                "css" => self::$paths['themes'][$inode->name]->theme_baseUrl_css,
                "js" => self::$paths['themes'][$inode->name]->theme_baseUrl_js,
            );
            Environnement::this()->Files->Themes[$inode->name]['realPath'] = array(
                "realPath" => self::$paths['themes'][$inode->name]->theme_realPath,
                "realPathCss" => self::$paths['themes'][$inode->name]->theme_realPath_css,
                "realPathJs" => self::$paths['themes'][$inode->name]->theme_realPath_js
            );
            //var_dump( self::$paths['themes'][$inode->name] );
        }

        //var_dump(Environnement::this()->Files->Themes);
        self::$environnement->basePaths =self::$paths['base'];
        self::$environnement->themes = self::$paths['themes'];
        Mvc::debug(self::$paths);
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
        $autoloadFile = (array)self::$config->paths->Files;
        while( $dir->folders->valid() ) {

            // @warning : Le dossier contenant les plugins doit avoir +x !
            if( is_file( $dir->folders->current()->realPath . '/' . $autoloadFile['%file_autoload%'] ) ) {
                include( $dir->folders->current()->realPath . '/' . $autoloadFile['%file_autoload%'] );
            }

            if( is_file( $dir->folders->current()->realPath . '/' . $autoloadFile['%file_config%'] ) ) {
                $configFile = $dir->folders->current()->realPath . '/' . $autoloadFile['%file_config%'];
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
            self::$config->paths->MVC->mvc_view = self::$config->paths->Pattern_Instance->instance_views . '' . $routedRoute->params['staticFile'] . self::DEFAULT_FILE_EXTENSION;
        }

        // Process paths
        self::$paths['mvc'] = self::$pathsProcessor->processBasePath(
            $mvcPlaceHolders,
            self::$config->paths->MVC
        );

        Mvc::debug(self::$paths);
        //var_dump(self::$paths);
    }


    static public function processInstanceHttpPaths() {
        $httpPaths = (array)self::$paths['instance'];
        array_walk($httpPaths,function(&$item){
            $item = Context::getBaseUrl() . $item;
        });
        self::$paths['http'] = $httpPaths;
        self::$environnement->urls->instance = $httpPaths;

        Mvc::debug(self::$paths['http']);
        //var_dump(self::$paths['http']);
    }

    static public function autoloadThemes() {
        // Pour chaques themes un nouvel objet theme.
        $themes = new \StdClass();

        $css = array();
        $js = array();

        $coreJs = array();
        $coreCss = array();
        // Pour chaques theme on injecte la baseUrl dans la config.
        foreach( self::$paths['themes'] as $k => $v ) {
            $conf           = Config::load( $v->theme_config_file, true );
            // inject
            $conf->BaseUrl  = ev()->Files->core['url'];
            $themes->$k     = new Theme( $conf, $v );

            // Preparation des chemins pour les fichiers provenant du core/assets/ et du themes courant
            $css        = array_merge( $css, $themes->$k->getThemeCss() );
            $js         = array_merge( $js, $themes->$k->getThemeJs() );
            $coreJs     = array_merge( $coreJs, $themes->$k->getCoreJs() );
            $coreCss    = array_merge( $coreCss, $themes->$k->getCoreCss() );
        }

        // Retire les doublons
        $coreJs = array_flip(array_flip($coreJs));
        $coreCss = array_flip(array_flip($coreCss));

        Environnement::this()->Files->js = array_merge( $coreJs, $js );
        Environnement::this()->Files->css = array_merge( $coreCss, $css );

        Mvc::debug($themes);
    }

    static public function viewObjectFactory() {
        $vo = new View\ViewObject();

        // Default body.
        if(is_file(self::$paths['mvc']->mvc_view)) {
            $partial = \LibreMVC\View::partial( self::$paths['mvc']->mvc_view, $vo );
            $vo->attachPartial( 'body' , $partial );
        }

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
            try {
                $template = new View\Template( self::$paths['mvc']->mvc_layout );
                $view = new View( $template, self::$viewObject );
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