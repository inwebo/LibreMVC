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



}