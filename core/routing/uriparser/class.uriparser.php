<?php

namespace LibreMVC\Routing;

use LibreMVC\Instance;
use LibreMVC\Http\Uri;
use LibreMVC\Routing\UriParser\SegmentConstraint;

//<editor-fold desc="Licence">
/**
 * LibreMVC
 *
 * LICENCE
 *
 * You are free:
 * to Share ,to copy, distribute and transmit the work to Remix —
 * to adapt the work to make commercial use of the work
 *
 * Under the following conditions:
 * Attribution, You must attribute the work in the manner specified by
 * the author or licensor (but not in any way that suggests that they
 * endorse you or your use of the work).
 *
 * Share Alike, If you alter, transform, or build upon
 * this work, you may distribute the resulting work only under the
 * same or similar license to this one.
 *
 *
 * @category  LibreMVC
 * @package   LibreMVC\Routing
 * @copyright Copyright (c) 2005-2014 Inwebo (http://www.inwebo.net)
 * @license   http://http://creativecommons.org/licenses/by-nc-sa/3.0/
 * @version   $Id:$
 * @link      https://github.com/inwebo/LibreMVC/tree/master/core/routing
 * @since     File available since Beta 01-01-2012
 */
//</editor-fold>

/**
 * Class UriParser
 *
 * Peuple la route Route avec les valeurs de l'uri URI.
 *
 * @package LibreMVC\Routing
 */
class UriParser {

    protected $uri;
    protected $route;
    protected $segmentConstraintClass;

    /**
     * @param Uri $uri L'URI entrante
     * @param Route $route La Route de comparai
     */
    public function __construct( Uri $uri, Route $route) {
        $this->uri      = $uri;
        $this->route    = $route;
    }

    /**
     * Compare chaques segments d'une uri aux segments d'une route.
     *
     * Va extraire le controller, l'action du controller ainsi que les eventuels parametres de l'uri pour les placer
     * dans la route courante.
     *
     * @return bool|Route False si les segments de l'uri ne valide pas les contraintes de segments, sinon la route correspondante.
     */
    public function processPattern() {
        $uriSegments    = $this->uri->toSegments();
        $routeSegments  = $this->route->toSegments();
        $j              = 0;
        $params         = array();

        foreach( $routeSegments as $routeSegment ) {

            if(isset($uriSegments[$j])) {
                // Alias segment courant
                $uriSegment = $uriSegments[$j];

                $constraint = new SegmentConstraint($uriSegment,$routeSegment );

                if( $constraint->isController() ) {
                    $this->route->controller = $constraint->getController();
                }
                if( $constraint->isAction() ) {
                    $this->route->action = $constraint->getAction();
                }
                // Est un parametre
                if( $constraint->isParam() ) {
                    // Est il typé
                    if( $routeSegment->isTypedParam() ) {
                        // valide t il la contrainte
                        if( $routeSegment->validateData( $uriSegment->getSegment() ) === false ) {
                            return false;
                        }
                    }
                    // Est il nommé
                    if( $routeSegment->isNamed() ) {
                        $params[$routeSegment->getParamName()] = $uriSegment->getSegment();
                    }
                    else {
                        $params[] = $uriSegment->getSegment();
                    }
                }
            }
            $j++;
        }
        $this->route->params = $params;
        return $this->route;
    }

}