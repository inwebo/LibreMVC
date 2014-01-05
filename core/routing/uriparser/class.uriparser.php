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
        foreach( $routeSegments as $routeSegment ) {

            if(isset($uriSegments[$j])) {
                $constraint = new SegmentConstraint($uriSegments[$j],$routeSegment );
                var_dump($constraint->getController());
                if( $constraint->isController() ) {
                    $this->route->controller = $constraint->getController();
                }
                if( $constraint->isAction() ) {
                    $this->route->action = $constraint->getAction();
                }
            }
            /*
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
            */
            $j++;
        }
        return $this->route;
    }

}