<?php

namespace LibreMVC\Models {

    use LibreMVC\Web\Instance\PathsFactory\Path;

    class Module {

        protected $_name;
        /**
         * @var Path
         */
        protected $_path;

        public function __construct($name, Path $path) {
            $this->_name = strtolower($name);
            $this->_path = $path;
        }
        public function getPath(){
            return $this->_path;
        }
        public function getName() {
            return $this->_name;
        }
        public function getBaseDir(){
            return $this->_path->dir();
        }
        public function getDirViews() {
            return $this->_path->getBaseDir("views");
        }
        public function getIndex() {
            return $this->_path->getBaseDir("index");
        }
        public function getStaticDir() {
            return $this->_path->getBaseDir("static_views");
        }
        public function getAssetsDir() {
            return $this->_path->getBaseDir("assets");
        }
        public function getJsDir() {
            return $this->_path->getBaseDir("js");
        }
        public function getCssDir() {
            return $this->_path->getBaseDir("css");
        }
        public function getConfig() {
            return $this->_path->getBaseDir("config");
        }

    }
}