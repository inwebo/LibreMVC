<?php
namespace LibreMVC\Http {

    class Request {

        static protected $_this;

        protected $_url;
        protected $_headers;

        private function __construct( Url $url) {
            $this->_url = $url;
            $this->_headers = self::getAllHeaders();
        }

        private function __clone(){}

        static public function this ( Url $http ) {
            if( is_null( self::$_this ) ) {
                self::$_this = new self($http);
                return self::$_this;
            }
            return self::$_this;
        }

        static public function getAllHeaders(){
            return getallheaders();
        }

        public function getUrl(){
            return $this->_url;
        }

        public function getHeaders(){
            return $this->_headers;
        }

        public function getHeader($name) {
            $headers = $this->getHeaders();
            if( isset($headers[$name]) ) {
                return $headers[$name];
            }
        }

        public function getInfos() {
            $o = new \StdClass();
            $o->url = $this->_url;
            $o->headers = $this->_headers;
            return $o;
        }

        static function isRestRequest() {

        }

    }
}