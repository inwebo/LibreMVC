<?php
namespace LibreMVC\Autoloader {

    use LibreMVC\String;

    class Decorators implements IAutoloadable{

        protected $_classInfos;
        protected $_baseDir;
        protected $_classFilePattern;
        protected $_vendorOffset;

        public function __construct($baseDir, $classFilePattern = 'class.{class}.php'){
            $this->_baseDir = $baseDir;
            $this->_classFilePattern = $classFilePattern;
        }

        public function load(ClassInfos $classInfos){
            $this->_classInfos = $classInfos;
            return is_file($this->toPath());
        }

        public function toPath(){
            $classInfos = $this->_classInfos->trim();

            $s = strtolower(
                String::replace(
                    $classInfos,
                    array(
                        '\\',
                        $this->_classInfos->getVendor()
                    ),
                    array(
                        '/',
                        $this->_baseDir
                    )
                )
            );
            $f = strtolower(
                String::replace(
                    $this->_classFilePattern,
                    array(
                        '{class}'
                    ),array(
                        $this->_classInfos->getClassName()
                    ))
            );


            return $s.'/'.$f;
        }

    }
}