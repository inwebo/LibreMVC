<?php

namespace LibreMVC\Web\Instance\PathsFactory {

    class Path implements IPathable{

        protected $_path;
        protected $_baseUrl;
        protected $_baseDir;

        public function __construct($path, $baseUrl, $baseDir) {
            $this->_path = $path;

            $this->_baseUrl = $baseUrl;
            $this->_baseDir = $baseDir;
        }

        public function url() {
            return $this->_baseUrl;
        }

        public function getBaseDir($el = null){
            $path = $this->_path;
            $baseDir = self::inject($path, $this->_baseDir);
            if( !is_null($el) ) {
                if( isset($baseDir[$el]) ) {
                    return $baseDir[$el];
                }
            }
            else {
                return $baseDir;
            }
        }

        public function getBaseUrl($el = null){
            $path = $this->_path;
            $baseUrl = self::inject($path, $this->_baseUrl);
            if( !is_null($el) ) {
                if( isset($baseUrl[$el]) ) {
                    return $baseUrl[$el];
                }
            }
            else {
                return $baseUrl;
            }
        }

        static public function  processPattern( $patterns, $values ) {
            $processed = array();
            foreach($patterns as $k => $pattern) {
                $processed[$k] = self::processPatternCallback($pattern, $values);
            }
            return (object)$processed;
        }

        static protected function processPatternCallback( $pattern, $value ) {
            $search = array_keys($value);
            $replace = array_values($value);
            return str_replace($search, $replace, $pattern);
        }

        static public function inject($array, $prefix) {
            array_walk($array,array("self","injectCallback"), $prefix);
            return $array;
        }

        static protected function injectCallback(&$item, $key, $prefix) {
            $item = $prefix . $item ;
        }

    }
}