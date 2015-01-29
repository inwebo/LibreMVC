<?php

namespace LibreMVC\System\Boot\Tasks\Task {

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
            $router = new RoutesRouter(
                Uri::this(),
                RoutesCollection::get('default'),
                self::ROUTE_CONSTRAINT
            );
            self::$_routed = $router->dispatch();
            return self::$_routed;
        }

        protected function end() {
            parent::end();
        }

    }
}