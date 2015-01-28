<?php

namespace LibreMVC\System\Boot {

    use LibreMVC\Files\Config;
    use LibreMVC\Http\Header;
    use LibreMVC\Http\Request;
    use LibreMVC\Models\Module;
    use LibreMVC\Patterns\AdjustablePriorityQueue;
    use LibreMVC\Routing\Route;
    use LibreMVC\Routing\RoutesCollection;
    use LibreMVC\Routing\Uri;
    use LibreMVC\System;
    use LibreMVC\Http\Url;
    use LibreMVC\View;
    use LibreMVC\Web\Instance;
    use LibreMVC\Web\Instance\PathsFactory\Path;
    use LibreMVC\Web\Instance\InstanceFactory;
    use LibreMVC\Routing\Router;
    use LibreMVC\Mvc\FrontController;
    use LibreMVC\System\Hooks\Hook\BindedHook;
    use LibreMVC\System\Hooks;

    class MVC implements IBootable{

        const ROUTE_CONSTRAINT = '\\LibreMVC\\Routing\\UriParser\\RouteConstraint';

        static protected $_configPath;
        static protected $_request;
        static protected $_config;
        /**
         * @var Hooks
         */
        static protected $_hooks;
        static protected $_basePaths;
        static protected $_appPaths;
        static protected $_instance;
        static protected $_instancePaths;
        static protected $_viewObject;
        static protected $_layout;
        /**
         * @var AdjustablePriorityQueue
         */
        static protected $_modules;
        /**
         * @var array
         */
        static protected $modules;
        /**
         * @var Route
         */
        static protected $_route;

        public function __construct($configPath){
            self::$_configPath = $configPath;
        }

        static public function request() {
            self::$_request = Request::this( Url::get() );
            return self::$_request;
        }

        static public function config(){
            self::$_config = Config::load(self::$_configPath);
            return self::$_config;
        }

        static public function hooks(){
            $hooksName = array_keys(self::$_config->Hooks);
            $total = count($hooksName);
            for($i=0;$i<$total;++$i) {
                $name = $hooksName[$i];
                Hooks::this()->$name = new BindedHook($name);
            }
            self::$_hooks = Hooks::this();
            return self::$_hooks;
        }

        static public function basePaths(){
            $basePaths = self::getBasePaths("base");
            $path = new Path( $basePaths, Url::get()->getUrl(), getcwd() . '/');
            self::$_basePaths = $path;
            return self::$_basePaths;
        }

        static public function appPaths(){
            $basePaths = self::getBasePaths("app");
            $path = new Path( $basePaths, Url::get()->getUrl(), getcwd() . '/');
            self::$_appPaths = $path;
            return self::$_appPaths;
        }

        static public function instance(){
            $factory = new InstanceFactory(Url::get()->getUrl(), self::$_config->Tokens['%dir_sites%']);
            $instance = $factory->search();
            if( is_null($instance) ) {
                self::$_instance = new Instance(self::$_appPaths->getBaseDir()['siteDefault']);
            }
            else {
                self::$_instance = $instance;
            }

            return self::$_instance;
        }

        static public function instancePaths(){
            $basePaths = self::getBasePaths("instance");

            // Instance par default config
            if( self::$_instance->getName() === trim(self::$_config->Tokens['%dir_site_default%'],"/") ) {
                $baseUrl = self::$_instance->getBaseUrl() . basename(self::$_instance->getParent()  ) . "/" . self::$_instance->getName() .'/';
                $baseDir = self::$_instance->getParent() . '/' . self::$_instance->getName() . '/' ;
            }
            // Named
            else {
                $baseUrl = self::$_instance->getBaseUrl() . self::$_instance->getParent(). '/' . self::$_instance->getName() . '/';
                $baseDir = getcwd() . '/' . self::$_instance->getParent() . '/' . self::$_instance->getName() . '/' ;
            }

            //var_dump(getcwd(),$baseUrl,$baseDir);

            $path = new Path( $basePaths, $baseUrl, $baseDir );

            self::$_instancePaths = $path;
            return self::$_instancePaths;
        }

        static public function autoloadInstance() {
            if(is_file(self::$_instancePaths->getBaseDir()['autoload'])) {
                include(self::$_instancePaths->getBaseDir()['autoload']);
            }
        }
        #region Helpers
        static protected function getBasePaths( $pattern ){
            $basePattern = (array)self::$_config->Pattern;
            $appPattern =  array_merge($basePattern, self::$_config->Root);
            $instancePattern =array_merge($appPattern, self::$_config->Instances);
            $modulesPattern = array_merge($basePattern, self::$_config->Instances);

            $array= array();
            $tokens = (array)self::$_config->Tokens;

            switch($pattern) {
                case "base":
                    $array = $basePattern;
                    break;

                case "app":
                    $array = $appPattern;
                    break;

                case "instance":
                    $array = $instancePattern;
                    break;

                case 'modules':
                    $array = $modulesPattern;
            }

            return (array)Path::processPattern($array,$tokens);

        }

        /**
         * Instance dir
         * @param $a
         * @return mixed
         */
        static protected function id($a){
            return self::$_instancePaths->getBaseDir()[$a];
        }
        static protected function mu($a){
            return self::$_instancePaths->getBaseurl()[$a];
        }
        static protected function getModuleBaseUrl($name) {
            return  self::mu('modules') . $name . "/";
        }
        static protected function getModuleBaseDir($name) {
            return  self::$_instancePaths->getBaseDir()['modules'] . $name . "/";
        }

        static protected function getModuleConfigPath($name) {
            $basePaths = self::getBasePaths("modules");
            return self::id('modules') . $name . "/". $basePaths['config'];
        }
        static protected function getModuleAutoload($name) {
            $basePaths = self::getBasePaths("modules");
            return self::id('modules') . $name . "/". $basePaths['autoload'];
        }

        #endregion

        static public function orderModulesByPriority() {
            $dirs = dir(self::$_instancePaths->getBaseDir()['modules']);
            $_modules = new AdjustablePriorityQueue(1);
            while( false !== ($entry = $dirs->read()) ){
                if( $entry !== "." && $entry !==".." ) {
                    $moduleConfigPath =  self::getModuleConfigPath($entry);
                    if(is_file($moduleConfigPath)) {
                        $conf = Config::load($moduleConfigPath);
                        $_modules->insert(
                            strtolower($conf->Module['name']),
                            (int) $conf->Module['priority']
                        );
                    }

                }
            }

            self::$_modules = $_modules;
            //return $_modules;
        }

        static public function modules() {
            $array = array();
            self::$_modules->setExtractFlags(\SplPriorityQueue::EXTR_BOTH);
            while(self::$_modules->valid()) {
                $path = new Path(
                    self::getBasePaths("modules"),
                    self::getModuleBaseUrl(self::$_modules->current()['data']),
                    self::getModuleBaseDir(self::$_modules->current()['data'])
                );

                $module = new Module(self::$_modules->current()['data'],$path);
                $array[self::$_modules->current()['data']] = $module;

                self::$_modules->next();
            }

            self::$modules = $array;
            return self::$modules;
        }

        static public function modulesAutoload() {
            foreach( self::$modules as $module ) {
                if( is_file($module->getPath()->getBaseDir()['autoload']) ) {
                    include($module->getPath()->getBaseDir()['autoload']);
                }
            }
        }

        static public function viewObject(){
            self::$_viewObject =new View\ViewObject();
            return self::$_viewObject;
        }

        static public function layout(){
            $layout =self::$_instancePaths->getBaseDir('index');
            System\Hooks::this()->__layout->call($layout);
            $layout = new View(
                new View\Template($layout),
                self::$_viewObject
            );
            self::$_layout = $layout;
            return self::$_layout;
        }


        static public function router(){
            $router = new Router(
                Uri::this(),
                RoutesCollection::get('default'),
                self::ROUTE_CONSTRAINT
            );
            self::$_route = $router->dispatch();
            return self::$_route;
        }

        static public function body(){
            // {controller}/{action}.php
            $viewsBaseDir = self::$_instancePaths->getBaseDir()['views'];
            $controller = self::$_route->controller;
            $body  = $viewsBaseDir . $controller::getControllerName().'/'.self::$_route->action.'.php';

            if( is_file($body) ) {
                self::$_viewObject->attachPartial('body', self::$_layout->partial($body, self::$_viewObject));
            }
            else {
                try {

                }
                catch(\Exception $e) {

                }
                Header::badRequest();
                trigger_error("Body template :" . $body . ' is missing');
            }

        }

        static public function lockSys(){
            System::this()->readOnly(true);
        }

        static public function frontController(){
            try {
                $front = new FrontController(
                    self::$_request,
                    self::$_route,
                    self::$_layout
                );
                $front->invoker();
            }
            catch(\Exception $e) {
                // Erreur 404
                Header::error(404);
                $defaultRoute = new Route('static/error');
                $defaultRoute->action = "error";
                $defaultRoute->controller = '\\LibreMVC\\Mvc\\Controller\\StaticController';
                $front->reroute($defaultRoute);
                $front->invoker();

            }
        }

    }
}