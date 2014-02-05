<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 01/11/13
 * Time: 23:15
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Helpers;


class NameSpaces {

    static public function isNamespaced( $class ) {
        return ( strpos($class , '\\' ) !== false ) ? true : false ;
    }

    static public function getControllerName( $controller ) {
        if( strpos($controller, '\\'  ) !== false) {
            $controllerArray = explode( '\\', strtolower( $controller ) );
            $controller = $controllerArray[count($controllerArray)-1];
            return explode('controller', $controller)[0];
        }
    }

    static public function getControllerSuffixedName( $controller ) {
        if( strpos($controller, '\\'  ) !== false) {
            $controllerArray = explode( '\\', strtolower( $controller ) );
            return $controllerArray[count($controllerArray)-1];
        }
    }

}