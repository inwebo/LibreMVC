<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 30/04/13
 * Time: 21:01
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Autoloader;

/**
 * Class Namespaces
 *
 * @package LibreMVC\Autoloader
 */
class Namespaces {

    protected $namespace;
    protected $absoluteNamespace;

    public function __construct( $namespaces ) {
        $this->namespace = $namespaces;
        $this->absoluteNamespace = $this->toAbsolute($this->namespace);
    }

    public function toAbsolute() {
        return '\\'.ltrim( $this->namespace, '\\' );
    }

    public function getConstructorPrefix() {

        if( $this->isNamespaced() ) {
            $asArray = explode('\\',$this->namespace);
            return array_shift($asArray);
        }
        else {
            return$this->namespace;
        }
    }

    static public function get( $namespaces ) {
        return new self( $namespaces );
    }

    public function toPath( $caseSensitive = false ) {
        $strReplace = str_replace('\\', DIRECTORY_SEPARATOR, $this->namespace);
        if( !$caseSensitive ) {
            $strReplace = strtolower($strReplace);
        }
        return $strReplace;
    }

    public function toFilePath( $keepPrefix = false, $pattern = "class.%className%.php", $caseSensitive = false ) {
        $dir = implode( '/', $this->toArray( $keepPrefix ) );
        $file = str_replace( "%className%", $this->className(), $pattern );
        $path = $dir . '/' . $file;
        return ( !$caseSensitive ) ? strtolower( $path ) : $path ;
    }

    public function isNamespaced() {
        return ( strpos($this->namespace, '\\') !== false ) ? true : false ;
    }

    public function toArray( $keepPrefix = true ) {
        if( $this->isNamespaced() ) {
            $array = explode( '\\', trim( $this->absoluteNamespace, '\\' ) );
            if( !$keepPrefix ) {
                array_shift($array);
            }
            return $array;
        }
        else {
            return $array[] = $this->namespace;
        }
    }

    public function className() {
        if( $this->isNamespaced() ) {
            $array = explode( '\\', trim( $this->absoluteNamespace, '\\' ) );
            return $array[count($array)-1];
        }
        else {
            return $this->namespace;
        }
    }

}