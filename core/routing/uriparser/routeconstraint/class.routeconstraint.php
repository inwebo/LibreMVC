<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 05/01/14
 * Time: 13:15
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Routing\UriParser\RouteConstraint;


use LibreMVC\Http\Uri;
use LibreMVC\Routing\Route;
use LibreMVC\Routing\UriParser\SegmentConstraint;

/**
 * Class RouteConstraint
 *
 * Détermine le type de route. Est elle une route nommée, une route par default. N'y a t il pas trop de segments dans l'url
 *
 * @package LibreMVC\Routing\UriParser\RouteConstraint
 */
class RouteConstraint {

    protected $valid;
    protected $uri;
    protected $route;

    public function __construct( Uri $uri, Route $route ) {
        $this->valid = false;
        $this->uri   = $uri;
        $this->route = $route;
    }

    public function isDefaultRoute() {
        return ( $this->uri->value !== "" && $this->uri->value !== "/" ) ? false : true ;
    }

    public function isNamedRoute() {
        return ( $this->uri->value === $this->route->name ) ;
    }

    public function isUriSegmentsGreaterThanRouteSegment() {
        return $this->uri->countSegments() > $this->route->countSegments();
    }

    /**
     * Tous les segments de l'uri valident t ils les segments de la route. Selon une SegmentConstraint.
     */
    public function isValidUri( $segmentConstraint ) {
        $valid = true;
        $uriSegments = $this->uri->toSegments();
        $routeSegments = $this->route->toSegments();

        $j = 0;
        foreach($routeSegments as $routeSegment) {

            if(isset($uriSegments[$j]) && $routeSegment->mandatory) {
                $segment = new $segmentConstraint($uriSegments[$j], $routeSegment);
                // Est il un segment obligatoire présent.
                $valid &= $segment->isValidMandatory();
                //var_dump($segment->isValidMandatory());
            }
            $j++;
        }
        //var_dump((bool)$valid);
        return (bool)$valid;
    }

}