<?php
/**
 * Created by JetBrains PhpStorm.
 * User: julien
 * Date: 22/04/13
 * Time: 13:08
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Routing;

// Doit renvoyer les segments obligatoire, facultatifs
// Appliques toutes les methodes des asserts sur l'uri courante.

use LibreMVC\Instance;
use LibreMVC\Routing\UriParser\Segment;
use LibreMVC\Http\Uri;
use LibreMVC\Routing\UriParser\SegmentConstraint;

/**
 * Class UriParser
 *
 *
 *
 * @package LibreMVC\Routing
 */
class UriParser {

    protected $uri;
    protected $route;
    protected $segmentConstraintClass;

    //protected $assertsObject;

    public $assertsResult = array();

    public function __construct( Uri $uri, Route $route) {
        $this->uri                    = $uri;
        $this->route                  = $route;

    }



    /**
     * Compare chaques segments d'une uri à ceux d'une route
     */
    public function processPattern() {
        $uriSegments = $this->uri->toSegments();
        $routeSegments = $this->route->toSegments();

        $j = 0;
        $params = array();
        foreach( $routeSegments as $routeSegment ) {

            if(isset($uriSegments[$j])) {
                $constraint = new SegmentConstraint($uriSegments[$j],$routeSegment );
                if( $constraint->isController() ) {
                    $this->route->controller = $constraint->getController();
                }
                if( $constraint->isAction() ) {
                    $this->route->action = $constraint->getAction();
                }
                // Est un parametre
                if( $constraint->isParam() ) {
                    // est il typé
                    if( $routeSegment->isTyped ) {
                        // valide t il la contrainte
                        if( $routeSegment->validateData( $uriSegments[$j]->segment ) ) {

                        }
                    }
                    else {

                    }

                    if( !is_null($routeSegment->paramName) ) {
                        $params[$routeSegment->paramName] = $uriSegments[$j]->segment;
                    }
                }
            }
            $j++;
        }
        var_dump($params);
        $this->route->params = $params;
        return $this->route;
    }

}