<?php
/**
 * Created by JetBrains PhpStorm.
 * User: julien
 * Date: 22/04/13
 * Time: 13:09
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Routing;

use LibreMVC\Http\Context;
use LibreMVC\Http\Header;
use LibreMVC\Mvc\Environnement;
use LibreMVC\Routing\UriParser;
use LibreMVC\Routing\RoutesCollection;
use LibreMVC\Routing\UriParser\RouteConstraint\RouteConstraint;
use LibreMVC\Routing\UriParser\SegmentConstraint;
use LibreMVC\Http\Uri;
/**
 * Class Router
 *
 * Iteration de toutes les routes connues contenues dans une RoutesCollection, pour chaque route instanciation d'un
 * UriParser avec comme logique une collection RouteRules.
 *
 * @package LibreMVC\Routing
 */
class Router {

    protected $uri;
    /**
     * @var RoutesCollection
     */
    protected $routesCollection;

    protected $routeConstraint;

    public function __construct( Uri $uri, RoutesCollection $routesCollection, $routeConstraintClass) {
        $this->uri              = $uri;
        $this->routesCollection = $routesCollection;
        $this->routeConstraint  = $routeConstraintClass;
    }

    /**
     * Parcours toute la collection de route, création d'un uriparser par route,
     */
    public function dispatch() {

        $this->routesCollection->routes->rewind();

        while($this->routesCollection->routes->valid()) {
            $routeConstraint = new RouteConstraint($this->uri, $this->routesCollection->routes->current() );

            // Est une route nommée.
            if( $routeConstraint->isNamedRoute() ) {
                return $this->routesCollection->routes->current();
            }

            // Est une uri qui valide un pattern de route.
            if( $routeConstraint->isValidUri("LibreMVC\\Routing\\UriParser\\SegmentConstraint") ) {
                // UriIsGreaterThanRoute
                if( $routeConstraint->isUriSegmentsGreaterThanRouteSegment() === false ) {
                    $parser = new UriParser( $this->uri,$this->routesCollection->routes->current());
                    return $parser->processPattern();
                }
            }

            $this->routesCollection->routes->next();
        }
        // Si on arrive ici est une route inconnue.
        Header::error(404);
        return $this->routesCollection->getDefaultRoute();

    }


}