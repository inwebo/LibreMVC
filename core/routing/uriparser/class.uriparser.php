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
        foreach( $routeSegments as $routeSegment ) {
            switch( $routeSegment->segment ) {
                case ":controller":
                    if( isset($uriSegments[$j]) ) {
                        $this->route->controller = $uriSegments[$j]->segment;
                    }
                    break;
                case ":action":
                    if( isset($uriSegments[$j]) ) {
                        $this->route->action = $uriSegments[$j]->segment;
                    }
                    break;

                case '[:instance]':
                    //$segment[] = Instance::getBaseDirRealPath();
                    break;

                default:
                    break;
            }
            $j++;
        }
        return $this->route;
        /**
         * Pour tous les segments du pattern d'une route
         */
        /*foreach( $patternArray as $value ) {

            // Est il requis et est il présent dans l'uri
                // Non route 404

                // Oui

            // Est il optionnel
            $optional = ( is_int( strpos( $value, '[' ) ) ) ? true : false;


            if( $optional !== false ) {

                // Obligatoire, le segment est il présent dans l'uri courante
                if( isset( $uriArray[$j] ) && $uriArray[$j] !== "/" ) {

                    switch( $value ) {
                        case "[:controller]":
                            $this->route->controller = $uriArray[$j];
                            break;

                        case "[:action]":
                            $this->route->action = $uriArray[$j];
                            break;

                        case '[:id]':
                            $params[] = $uriArray[$j];
                            break;

                        case '[:instance]':
                            //$segment[] = Instance::getBaseDirRealPath();
                            break;

                        default:
                            break;
                    }

                    if( strpos( $value, ':id|' ) !== false ) {
                        $parmName = explode( '|', $value );
                        $params[trim($parmName[1],']')] = $uriArray[$j];
                    }
                }
                $this->route->params = $params;
            }

            $j++;
        }
        return $this->route;*/
    }

}