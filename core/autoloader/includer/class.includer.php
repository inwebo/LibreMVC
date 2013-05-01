<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 28/04/13
 * Time: 16:31
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Autoloader;


class Includer {

    public $class;
    public $prefixConstructor;
    protected $nameSpaced = -1;
    protected $pool;
    protected $fileName;
    protected $includePath;

    public function __construct($class, $prefixConstructor, $pool) {
        $this->class = $this->toAbsoluteNameSpace($class);
        $this->prefixConstructor = $this->toAbsolutePrefixConstructor($prefixConstructor);
        $this->pool = $this->getPool($pool);
        $this->nameSpaced = $this->isNameSpaced($this->class);
        $this->nameSpace = $this->getNameSpace(true);
        $this->includePath = $this->getIncludePath($this->class);
        $this->fileName = $this->getFileName($this->includePath);

        // Creation nouvel objet namspace
    }

    public function getPath($pool, $keepPrefix =false ) {
        return strtolower($this->getPool($pool) .'/'. $this->getNameSpaceAsDir( $this->getNameSpace($keepPrefix) )  . '/class.'.$this->fileName.'.php');
    }

    protected function getPool($pool) {
        return rtrim($pool,'/');
    }

    protected function toAbsoluteNameSpace( $class ) {
        return '\\'.ltrim($class,'\\');
    }

    public function getNameSpace( $keepPrefix = true ) {
        if($keepPrefix === false) {
            $prefix = explode('\\', $this->class);
            $prefix = array_filter($prefix);
            array_shift($prefix);
            return implode('/',$prefix);
        }
        return $this->class;
    }

    protected function toAbsolutePrefixConstructor( $class ) {
        return '\\'.trim($class,'\\') . "\\";
    }

    public function getIncludePath($class) {
        return strtolower(str_replace('\\', DIRECTORY_SEPARATOR, $class));
    }

    public function getFileName($includePath) {
        if( $this->nameSpaced === false ) {
            return $includePath;
        }
        else {
            $t = explode('/',  $this->includePath );
            return $t[count($t)-1];
        }
    }

    public function getNameSpaceAsDir( $includePath, $keepPrefix = false ) {
        if( strpos($includePath, $this->getIncludePath($this->prefixConstructor)) !== false && $keepPrefix === false) {
            return str_replace($this->getIncludePath($this->prefixConstructor),'',$includePath);
        }
        else {
            return ltrim($includePath,'/');
        }
    }

    public function isNameSpaced($class) {
        return ( strpos($class, '\\') !== false ) ? true : false ;
    }

}