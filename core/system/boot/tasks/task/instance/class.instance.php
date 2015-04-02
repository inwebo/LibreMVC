<?php

namespace LibreMVC\System\Boot\Tasks\Task {

    use LibreMVC\Files\Config;
    use LibreMVC\System;
    use LibreMVC\System\Boot\Tasks\Task;
    use LibreMVC\Http\Url;
    use LibreMVC\System\Hooks;
    use LibreMVC\Web\Instance as WebInstance;
    use LibreMVC\Web\Instance\InstanceFactory;
    use LibreMVC\Web\Instance\PathsFactory\Path;

    class Instance extends Task{

        public function __construct(){
            parent::__construct();
            $this->_name ='Instance';
        }

        protected function start() {
            parent::start();
        }

        protected function instance(){
            //var_dump(self::$_config);
            $factory = new InstanceFactory(Url::get()->getUrl(), self::$_config->Tokens['%dir_sites%']);
            $instance = $factory->search();

            if( is_null($instance) ) {
                // Est une redirection
                self::$_instance = new WebInstance(self::$_appPaths->getBaseDir()['siteDefault']);
                // Change body par fichier static
            }
            else {
                self::$_instance = $instance;
            }

            return self::$_instance;
        }

        protected function instancePaths(){
            $basePaths = Paths::getBasePaths("instance");

            // Instance par default config
            if( self::$_instance->getName() === trim(self::$_config->Tokens['%dir_site_default%'],"/") ) {
                $baseUrl = self::$_instance->getBaseUrl() . basename(self::$_instance->getParent()  ) . "/" . self::$_instance->getName() .'/';
                $baseDir = self::$_instance->getParent() . '/' . self::$_instance->getName() . '/' ;
            }
            // Named
            else {
                $baseUrl = self::$_instance->getBaseUrl() . self::$_instance->getParent(). '/' . self::$_instance->getName() . '/';
                $baseDir = getcwd() . '/' . self::$_instance->getParent() . '/' . self::$_instance->getName() . '/' ;
            }

            //var_dump(getcwd(),$baseUrl,$baseDir);

            $path = new Path( $basePaths, $baseUrl, $baseDir, self::$_tokens );

            self::$_instancePaths = $path;
            return self::$_instancePaths;
        }

        protected function autoloadInstance() {
            if(is_file(self::$_instancePaths->getBaseDir()['autoload'])) {
                include(self::$_instancePaths->getBaseDir()['autoload']);
            }
        }

        protected function autoloadConfig() {
            $config = self::$_instancePaths->getConfig('dir');
            System::this()->instanceConfig = Config::load($config);
            return self::$_instanceConfig;
        }

        protected function end() {
            parent::end();
        }

    }
}