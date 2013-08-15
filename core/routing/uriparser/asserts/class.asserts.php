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

    static public $isValidParam = true;

    protected  function __construct() {}

    static public function load() {
        return new Asserts();
    }

    static public function isDefaultRoute( $uri ) {
        return ( $uri->value !== "" && $uri->value !== "/" ) ? false : true ;
    }

    static public function isNamedRoute( $uri, $route ) {
        // Chaine commence par route name
        return ( $uri->value === $route->name ) ;
    }

    static public function isUriGreaterThanRoute( $uri, $route ) {
        return ( count($uri->toArray()) > count($route->patternToArray()) );
    }

    static public function isValidPattern($uri, $route) {
        //@todo refactoring
        $valid = true;
        $uriArray = $uri->toArray();
        $patternArray = $route->patternToArray();

        //var_dump($patternArray);
        $j = 0;
        foreach( $patternArray as $value ) {
            //echo $patternArray[$j];
            // Creation
            $segment = new Segment($patternArray[$j], $uriArray[$j]);
            //var_dump($segment);

            $mandatory  = !( is_int( strpos($value,'[') ) ) ? true : false;
            //echo (int) $mandatory;
            $requiredName = self::cleanParam($value);

            // Segment obligatoire
            if( $mandatory ) {
                if( !isset( $uriArray[$j] ) || $uriArray[$j] != $value ) {
                    return false;
                }
            }

            if( !self::isParam($requiredName) && !self::isSlash($requiredName) && isset($uriArray[$j]) && $requiredName !== $uriArray[$j] ) {
                return false;
            }


            if( self::isParam(trim($patternArray[$j], '[]')) && isset($uriArray[$j]) ) {
                //echo $uriArray[$j];
                    $param = new Segment($patternArray[$j], $uriArray[$j]);
                    self::$isValidParam = self::$isValidParam || $param->valid;
                if( $param->valid === false  ) {
                    return false;
                }
            }

            $j++;
        }
        return $valid;
    }

    static public function isValidParam() {
        return self::$isValidParam;
    }

    static protected function cleanParam( $string ) {
        return trim(trim($string,'['),']');
    }

    //@todo + finement :id
    static protected function isParam( $string ) {
        return ($string[0] === ":") ;
    }

    static protected function isSlash( $string ) {
        return ($string === '/');
    }
}

