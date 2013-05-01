<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 22/04/13
 * Time: 20:11
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMCV\Routing\UriParser;

use \LibreMCV\Routing\Route\Segment as Segment;

class Asserts {

    protected  function __construct() {}

    static public function load() {
        return new Asserts();
    }

    static public function isDefaultRoute( $uri ) {
        return ( $uri->value !== "" && $uri->value !== "/" ) ? false : true ;
    }

    static public function isNamedRoute( $uri, $route ) {
        // Chaine commence par route name
        return ( $uri->value === $route->name ) ? true : false ;
    }

    static public function isUriGreaterThanRoute( $uri, $route ) {

        $iuri = count($uri->toArray());
        $ipat = count($route->patternToArray());

        //echo $iuri,$ipat,(int)( $iuri > $ipat );

        return ( $iuri > $ipat );
    }

    static public function isValidPattern($uri, $route) {
        $valid = true;
        $uriArray = $uri->toArray();
        $patternArray = $route->patternToArray();

        $j = 0;
        foreach( $patternArray as $value ) {

            $facultative = ( is_int( strpos($value,'[') ) ) ? true : false;

            // Segment obligatoire
            if( $facultative === false ) {

                if( !isset( $uriArray[$j] ) || $uriArray[$j] != $value ) {
                    return false;
                }

            }

            $j++;
        }
        return $valid;
    }
}

