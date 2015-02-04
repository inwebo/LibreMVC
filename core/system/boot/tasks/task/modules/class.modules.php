<?php

namespace LibreMVC\System\Boot\Tasks\Task {

    use LibreMVC\System\Boot\Tasks\Task;
    use LibreMVC\Files\Config;
    use LibreMVC\System\Hooks;
    use LibreMVC\Patterns\AdjustablePriorityQueue;
    use LibreMVC\Models\Module;
    use LibreMVC\Web\Instance\PathsFactory\Path;

    class Modules extends Task{



        public function __construct(){
            parent::__construct();
            $this->_name ='Modules';

        }

        protected function start() {
            parent::start();
        }

        protected function orderModulesByPriority() {
            $dirs = dir(self::$_instancePaths->getBaseDir()['modules']);
            $_modules = new AdjustablePriorityQueue(1);
            while( false !== ($entry = $dirs->read()) ){
                if( $entry !== "." && $entry !==".." ) {
                    $moduleConfigPath =  self::getModuleConfigPath($entry);
                    if(is_file($moduleConfigPath)) {
                        $conf = Config::load($moduleConfigPath);
                        $_modules->insert(
                            strtolower($conf->Module['name']),
                            (int) $conf->Module['priority']
                        );
                    }

                }
            }

            self::$_modulesQueue = $_modules;

        }
        protected function modules() {
            $array = array();
            self::$_modulesQueue->setExtractFlags(\SplPriorityQueue::EXTR_BOTH);
            while(self::$_modulesQueue->valid()) {
                $path = new Path(
                    Paths::getBasePaths("modules"),
                    self::getModuleBaseUrl(self::$_modulesQueue->current()['data']),
                    self::getModuleBaseDir(self::$_modulesQueue->current()['data'])
                );

                $module = new Module(self::$_modulesQueue->current()['data'],$path);
                $array[self::$_modulesQueue->current()['data']] = $module;

                self::$_modulesQueue->next();
            }

            self::$_modules = $array;
            return self::$_modules;
        }
        protected function modulesAutoload() {
            foreach( self::$_modules as $module ) {
                if( is_file($module->getPath()->getBaseDir()['autoload']) ) {
                    include($module->getPath()->getBaseDir()['autoload']);
                }
            }
        }
        #region Helper
        static public function getModuleBaseUrl($name) {
            return  self::mu('modules') . $name . "/";
        }
        static public function getModuleBaseDir($name) {
            return  self::$_instancePaths->getBaseDir()['modules'] . $name . "/";
        }

        static public function getModuleConfigPath($name) {
            $basePaths = Paths::getBasePaths("modules");
            return self::id('modules') . $name . "/". $basePaths['config'];
        }
        static public function getModuleAutoload($name) {
            $basePaths = self::getBasePaths("modules");
            return self::id('modules') . $name . "/". $basePaths['autoload'];
        }
        static public function id($a){
            return self::$_instancePaths->getBaseDir()[$a];
        }
        static public function mu($a){
            return self::$_instancePaths->getBaseurl()[$a];
        }
        #endregion
        protected function end() {
            parent::end();
        }

    }
}