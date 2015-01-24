<?php

namespace LibreMVC\Autoloader {

    /**
     * Class CoreClass
     *
     * @package LibreMVC\Autoloader
     */
    class ClassInfos {

        protected $_class;

        public function __construct( $class ) {
            $this->_class = $class;
        }

        public function trim() {
            return  trim( $this->_class, '\\' );
        }

        public function isNamespaced() {
            return ( strpos($this->_class, '\\') !== false ) ? true : false ;
        }

        public function getVendor($offset=1) {
            if( $this->isNamespaced() ) {
                $asArray = explode( '\\', $this->trim() );
                if( $offset > 1 ) {
                    $a = $asArray;
                    $toPop = count($a) - $offset;
                    for($i=0;$i<$toPop;$i++){
                        array_pop($a);
                    }
                    return implode('\\',$a);
                }
                else {
                    return ( isset( $asArray[0] ) && !empty( $asArray[0] ) ) ? $asArray[0] : $this->_class;
                }

            }
            else {
                return null;
            }
        }

        public function getClassName() {
            $v = $this->toArray();
            return end($v);
        }

        public function toAbsolute() {
            return '\\' . $this->trim();
        }

        public function toArray() {
            $v = array();
            if( $this->isNamespaced() ) {
                $array = explode( '\\', $this->trim() );
                $v = $array;
            }
            else {
                $v[] = $this->_class;
            }
            return $v;
        }

        public function __get($member){
            if( isset($this->$member) ) {
                return $this->$member;
            }
        }
    }

}