<?php
namespace LibreMVC\Routing {

    class RouterExceptionError404 extends \Exception {};

    use LibreMVC\Http\Header;
    use LibreMVC\Routing\UriParser\RouteConstraint;

    /**
     * Class Router
     *
     * Iteration de toutes les routes connues contenues dans une RoutesCollection, pour chaque route instanciation d'un
     * UriParser avec comme logique une collection RouteRules.
     *
     * @package LibreMVC\Routing
     */
    class Router {

        protected $_uri;
        protected $_routesCollection;
        protected $_defaultRoute;

        public function __construct( Uri $uri, RoutesCollection $routesCollection) {
            $this->_uri              = $uri;
            $this->_routesCollection = $routesCollection;
        }

        public function routeConstraintFactory(Route $route){
            return new RouteConstraint($this->_uri, $route );
        }

        public function dispatch() {
            $this->_routesCollection->routes->rewind();
            while($this->_routesCollection->routes->valid()) {
                $routeConstraint = $this->routeConstraintFactory( $this->_routesCollection->routes->current() );

                // Est une route nommée.
                if( $routeConstraint->isNamedRoute() ) {
                    return $this->_routesCollection->routes->current();
                }

                // Est une uri qui valide un pattern de route.
                if( $routeConstraint->isValidUri("LibreMVC\\Routing\\UriParser\\SegmentConstraint") ) {

                    // UriIsGreaterThanRoute
                    if( $routeConstraint->isUriSegmentsGreaterThanRouteSegments() === false ) {
                        $parser = new UriParser( $this->_uri, $this->_routesCollection->routes->current() );
                        return $parser->processPattern();
                    }
                    // Uri invalide 404
                    else {
                        if( !is_null($this->_defaultRoute) ) {
                            Header::notFound();
                            return $this->_defaultRoute;
                        }
                        else {

                            throw new RouterExceptionError404('Uri : ' . $this->_uri->value . ' is not a valid uri.');
                        }
                    }
                }

                $this->_routesCollection->routes->next();
            }
            // Si on arrive ici est une route inconnue.
            //throw new RouterExceptionError404('Router : route 404 Not found');
            return false;
        }

        public function attachDefaultRoute(Route $route){
            $this->_defaultRoute = $route;
        }

    }
}