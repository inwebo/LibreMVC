<?php
namespace LibreMVC {

    use LibreMVC\Ftp\Config\Config;
    use LibreMVC\Ftp\Resource;

    class Ftp {

        /**
         * @var array
         */
        protected $_servers = array();

        public function __construct() {

        }

        public function addServer(Config $config, $usr = null, $pwd = null) {
            try {
                /* @var \LibreMVC\Ftp\Resource $resource */
                $resource = new Resource($config);
                if( !is_null($usr) && !is_null($pwd) ) {
                    $return = $resource->login($usr, $pwd);
                }
                else {
                    $return = $resource->loginAnonymously();
                }
                $this->_servers[$resource->getConfig()->getHost()] = $resource;
                return $return;
            }
            catch(\Exception $e) {
                throw $e;
            }
        }

        /**
         * @param $server
         * @return \LibreMVC\Ftp\Resource
         */
        public function getServer($server) {
            if( isset($this->_servers[$server]) ) {

                return $this->_servers[$server];
            }
        }

    }
}