<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 22/04/13
 * Time: 20:11
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Routing\UriParser;


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
        return ( count($uri->toArray()) > count($route->patternToArray()) );
    }

    static public function isValidPattern($uri, $route) {
        $valid = true;
        $uriArray = $uri->toArray();
        $patternArray = $route->patternToArray();

        $j = 0;
        foreach( $patternArray as $value ) {

            $mandatory  = ( is_int( strpos($value,'[') ) ) ? true : false;
            $requiredName = self::cleanParam($value);

            // Segment obligatoire
            if( !$mandatory ) {

                if( !isset( $uriArray[$j] ) || $uriArray[$j] != $value ) {
                    return false;
                }

            }

            if( !self::isParam($requiredName) && !self::isSlash($requiredName) && isset($uriArray[$j]) && $requiredName !== $uriArray[$j] ) {
                return false;
            }

            $j++;
        }
        return $valid;
    }

    static protected function cleanParam( $string ) {
        return trim(trim($string,'['),']');
    }

    static protected function isParam( $string ) {
        return ($string[0] === ":") ;
    }

    static protected function isSlash( $string ) {
        return ($string === '/');
    }
}

