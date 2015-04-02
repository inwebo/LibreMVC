<?php

namespace LibreMVC\System\Boot\Tasks\Task {

    use LibreMVC\Routing\RouterError404;
    use LibreMVC\System\Boot\Tasks\Task;
    use LibreMVC\System\Hooks;
    use LibreMVC\Routing\Router as RoutesRouter;
    use LibreMVC\View\Template;
    use LibreMVC\View;
    use LibreMVC\Routing\Uri;
    use LibreMVC\Routing\RoutesCollection;


    class Router extends Task{
        const ROUTE_CONSTRAINT = '\\LibreMVC\\Routing\\UriParser\\RouteConstraint';
        public function __construct(){
            parent::__construct();
            $this->_name ='Router';
        }

        protected function start() {
            parent::start();
        }

        protected function routed(){

            try {
                $router = new RoutesRouter(
                    Uri::this(),
                    RoutesCollection::get('default'),
                    self::ROUTE_CONSTRAINT
                );

                $routed = $router->dispatch();
                self::$_routed = $routed;
            }
            catch(\Exception $e) {
                self::$_exceptions[] = $e;
            }
            return self::$_routed;
        }
/*
        protected function validateRouteController() {
            if( !is_null(self::$_routed) ) {
                // Est un controller valide
                if( !class_exists(self::$_routed->controller) ) {
                    self::$_exceptions[] = new RouterError404("Unknown controller " . self::$_routed->controller . ", check typo or create the needed file.");
                }
            }
            else {
                self::$_exceptions[] = new RouterError404("Unknown route, check typo or create the needed file.");
            }
        }
*/
        protected function end() {
            parent::end();
        }

    }
}