<?php

namespace LibreMVC;

class ClassNamespace {

    protected $namespace;
    protected $absoluteNamespace;
    protected $className;
    protected $vendorPrefix;

    public function __construct( $namespaces ) {
        $this->namespace = $namespaces;
        $this->absoluteNamespace = $this->toAbsolute( $this->namespace );
        $this->vendorPrefix = $this->getVendorPrefix();
        $this->className = $this->getClassName();
    }

    public function toAbsolute() {
        return '\\' . ltrim( $this->namespace, '\\' );
    }

    public function registerClass() {
        $file = $this->toFilePath();
        if( is_file($file) ) {
            if( include($file) !== false ) {
                return true;
            }
            else {
                return false;
            }
        }
        else {
            return false;
        }
    }

    public function getVendorPrefix() {

        if( $this->isNamespaced() ) {
            $asArray = explode( '\\', trim( $this->namespace, '\\' ) );
            return ( isset( $asArray[0] ) && !empty( $asArray[0] ) ) ? $asArray[0] : $this->namespace;
        }
        else {
            return $this->namespace;
        }
    }

    static public function get( $namespaces ) {
        return new self( $namespaces );
    }

    public function getNamespace() {
        return $this->namespace;
    }

    public function toPath( $caseSensitive = false ) {
        $strReplace = str_replace('\\', '/', $this->namespace);
        if( !$caseSensitive ) {
            $strReplace = strtolower($strReplace);
        }
        return $strReplace;
    }

    public function toFilePath( $keepPrefix = false, $pattern = "class.%getClassName%.php", $caseSensitive = false ) {
        $dir = implode( '/', $this->toArray( $keepPrefix ) );
        $file = str_replace( "%getClassName%", $this->getClassName(), $pattern );
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

    public function getClassName() {
        if( $this->isNamespaced() ) {
            $array = explode( '\\', trim( $this->absoluteNamespace, '\\' ) );
            return $array[count($array)-1];
        }
        else {
            return $this->namespace;
        }
    }

}

class AutoLoadDecorator extends \FilterIterator {

    protected $_class;

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Check whether the current element of the iterator is acceptable
     * @link http://php.net/manual/en/filteriterator.accept.php
     * @return bool true if the current element is acceptable, otherwise false.
     */
    public function accept() {
        if( strpos( $this->current(), $this->_class ) !== false ){
            return true;
        }
        else {
            return false;
        }
        //return ( strpos( $this->current(), $this->_class ) !== false );
    }

    public function setClass( $class ) {
        $this->_class = $class;
    }
}

class AutoLoader {

    static protected $_instance;
    protected $_pools;
    protected $_loaded;
    protected $_class;

    protected function __construct() {
        $this->_pools = array('./core/','./sites/_default/');
        $this->_loaded = array();
    }

    final function __clone() {}

    static public function registerClass( $file ) {
        if( is_file($file) ) {
            include($file);
        }
    }

    static public function handler( $class ) {
        self::instance()->_class = $class;
        if( !is_null(self::instance()->_loaded) && !array_key_exists(self::instance()->_class, self::instance()->_loaded) ) {
            self::instance()->findByNamespace();
        }
    }

    static public function instance() {
        if( !isset( self::$_instance ) ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function addPool( $path ) {
        if( is_dir( $path ) && is_readable( $path ) ) {
            $this->_pools[] = $path;
        }
        elseif( !is_dir( $path ) ) {
            trigger_error( $path . ' is not a dir.' );
        }
        elseif( !is_readable( $path ) ) {
            trigger_error( $path . ' is not readable.' );
        }
        return $this;
    }

    public function findByNamespace() {
        $nc = new ClassNamespace($this->_class);
        foreach ( $this->_pools as $directory ){
            if(is_file( $directory . $nc->toFilePath() ) ) {
                self::instance()->_loaded[$this->_class] = $directory . $nc->toFilePath();
                //var_dump(self::instance()->_loaded);
                include_once($directory . $nc->toFilePath());
                //@ todo Class alias automatique
                $base =$nc->getNamespace();
                $alias = $nc->getClassName();
                //if( !class_exists($base) && !class_exists($alias) ) {
                    //class_alias($base,$alias);
                //}
                return;
            }
        }
    }

    public function includePools() {

        $nc = new ClassNamespace($this->_class);

        foreach ( $this->_pools as $directory ){

            $directories = new \AppendIterator ();
            $directories->append ( new \RecursiveIteratorIterator ( new \RecursiveDirectoryIterator ( $directory, \FilesystemIterator::SKIP_DOTS ) ) );
            $files = new \LibreMVC\AutoLoadDecorator ( $directories );
            $files->setClass( $nc->toFilePath() );
            foreach ( $files as $fileName ){
                $this->_loaded[$this->_class] = $fileName->getRealPath();
                include_once( $fileName->getRealPath() );
            }

            if(is_file( $directory . $nc->toFilePath() ) ) {
                include_once($directory . $nc->toFilePath());
                return;
            }
        }
    }

}