<?php

namespace LibreMVC\System\Boot {

    use LibreMVC\Files\Config;
    use LibreMVC\Http\Header;
    use LibreMVC\Http\Request;
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

    class MVC implements IBootable{

        const ROUTE_CONSTRAINT = '\\LibreMVC\\Routing\\UriParser\\RouteConstraint';

        static protected $_configPath;
        static protected $_request;
        static protected $_config;
        static protected $_basePaths;
        static protected $_appPaths;
        static protected $_instance;
        static protected $_instancePaths;
        static protected $_viewObject;
        static protected $_layout;
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

        static public function basePaths(){
            $basePaths = (array)Path::processPattern((array)self::$_config->Pattern,(array)self::$_config->Tokens);
            $path = new Path( $basePaths, Url::get()->getUrl(), getcwd() . '/');
            self::$_basePaths = $path;
            return self::$_basePaths;
        }

        static public function appPaths(){
            $basePaths = (array)Path::processPattern(array_merge(self::$_config->Pattern, self::$_config->Root),(array)self::$_config->Tokens);
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
            $basePaths = (array)Path::processPattern(array_merge(self::$_config->Pattern, self::$_config->Root, self::$_config->Instances),(array)self::$_config->Tokens);
            $path = new Path( $basePaths, self::$_instance->getBaseUrl() . self::$_instance->getParent(). '/' . self::$_instance->getName() . '/', getcwd() . '/' . self::$_instance->getParent() . '/' . self::$_instance->getName() . '/' );
            self::$_instancePaths = $path;
            return self::$_instancePaths;
        }

        static public function autoloadInstance() {
            if(self::$_instancePaths->getBaseDir()['autoload']) {
                include(self::$_instancePaths->getBaseDir()['autoload']);
            }
        }

        static public function autoloadModule() {
            // Pour tous les modules contenus dans l'instance courante
            $dirs = dir(self::$_instancePaths->getBaseDir()['modules']);
            while( false !== ($entry = $dirs->read()) ){
                if( $entry !== "." && $entry !==".." ) {
                    if (is_file(self::$_instancePaths->getBaseDir()['modules'] . $entry . '/' . self::$_config->Tokens['%autoload%'])) {
                        include(self::$_instancePaths->getBaseDir()['modules'] . $entry . '/' . self::$_config->Tokens['%autoload%']);
                    }
                }
            }
        }

        static public function viewObject(){
            self::$_viewObject =new View\ViewObject();
            return self::$_viewObject;
        }

        static public function layout(){
            $layout = new View(
                new View\Template(self::$_instancePaths->getBaseDir()['index']),
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
                //Header::error(500);
                Header::badRequest();
                //trigger_error("Body template :" . $body . ' is missing');
            }

        }

        static public function lockSys(){
            //var_dump(System::this());
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