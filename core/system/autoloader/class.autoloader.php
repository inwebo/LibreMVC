<?php
namespace LibreMVC\System;
use LibreMVC\Controllers;

/**
  * My Framework : My.Forms
  *
  * LICENCE
  *
  * You are free:
  * to Share ,to copy, distribute and transmit the work to Remix —
  * to adapt the work to make commercial use of the work
  *
  * Under the following conditions:
  * Attribution, You must attribute the work in the manner specified by
  *   the author or licensor (but not in any way that suggests that they
  *   endorse you or your use of the work).
  *
  * Share Alike, If you alter, transform, or build upon
  *     this work, you may distribute the resulting work only under the
  *     same or similar license to this one.
  *
  *
  * @category   My.Forms
  * @package    Extra
  * @copyright  Copyright (c) 2005-2011 Inwebo (http://www.inwebo.net)
  * @license    http://http://creativecommons.org/licenses/by-nc-sa/3.0/
  * @version    $Id:$
  * @link       https://github.com/inwebo/My.Forms
  * @since      File available since Beta 01-10-2011
  */

class AutoLoader {
    
    static public $registeredClasses = array();
    static public $filePrefix = "class.";
    static public $fileExtension = ".php";
    static public $poolPathes = array();
    static public $namespacePattern = "libremvc";

    static public function addPool( $path ) {
        self::$poolPathes[] = $path;
    }
    
    static protected function isLoadable( $path ) {
        if( is_file($path) ) {
            include ($path);
            return;
        }
    }
    
    static protected function toIncludePath( $class, $str_replace ) {
        return str_replace( self::$namespacePattern, $str_replace, implode( "/", array_filter( self::namespaceToPath( $class ), "strlen" ) ) );
    }
    
    static protected function namespaceToPath( $class ) {
        $pathComponents = array_map( "strtolower", explode( '\\' , $class ) );
        $file = self::$filePrefix . strtolower($pathComponents[count($pathComponents) -1 ]) . self::$fileExtension;
        array_push($pathComponents, $file);
        return $pathComponents;
    }
    
    static public function load($class) {
        $j = -1;
        while(isset( self::$poolPathes[++$j] )) {
            $path = trim(self::toIncludePath( $class, self::$poolPathes[$j] ), "/");
            self::isLoadable($path);
            self::$registeredClasses[] = $path;
        }
    }
}