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
        $this->uri             = $uri;
        $this->routesCollection = $routesCollection;
        $this->routeConstraint = $routeConstraintClass;
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

                /**
                 * Set les valeurs Controller, Action, Params pour la route courante
                 */

                $parser = new UriParser( $this->uri,$this->routesCollection->routes->current());

                return $parser->processPattern();

            }

            $this->routesCollection->routes->next();
        }

/*
        while( isset( $this->routeCollection[++$j] ) ) {
            $parser = new UriParser( $this->uri, $this->routeCollection[$j], $this->asserts );


            // @todo developper cette partie finement

             //@important Est nécessaire pour garder l'unicité des uris. elles doivent être uniques.
              //@todo : bug routing, ex : category/1 ne fonctionne pas

            if($parser->assertsResult['isUriGreaterThanRoute']) {
                echo "isUriGreaterThanRoute === true";
                return null;
            }

            if( $parser->assertsResult['isNamedRoute'] ) {
                // Redirection, unicité des routes
                Header::movedPermanently();
                header('Location: ' . Context::getServer( true, true ) .$this->routeCollection[$j]->pattern);
                return $this->routeCollection[$j];
            }

            if( $parser->assertsResult['isValidSegment'] === false ) {
                echo "isValidSegment === false";
                return null;
            }

            if( $parser->assertsResult['isValidPattern'] ) {
                return $parser->processPattern();
            }

        }
*/
    }


}