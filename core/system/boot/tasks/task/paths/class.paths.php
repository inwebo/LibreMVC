<?php

namespace LibreMVC\System\Boot\Tasks\Task {

    use LibreMVC\System\Boot\Tasks\Task;
    use LibreMVC\Http\Url;
    use LibreMVC\System\Hooks;
    use LibreMVC\Web\Instance\PathsFactory\Path;

    class Paths extends Task{

        public function __construct(){
            parent::__construct();
            $this->_name ='Paths';
        }

        protected function start() {
            parent::start();
        }

        protected function basePaths(){
            $basePaths = self::getBasePaths("base");
            $path = new Path( $basePaths, Url::get()->getUrl(), getcwd() . '/');
            self::$_basePaths = $path;
            return self::$_basePaths;
        }

        protected function appPaths(){
            $basePaths = self::getBasePaths("app");
            $path = new Path( $basePaths, Url::get()->getUrl(), getcwd() . '/');
            self::$_appPaths = $path;
            return self::$_appPaths;
        }

        #region Helpers
        static public function getBasePaths( $pattern ){
            $basePattern = (array)self::$_config->Pattern;
            $appPattern =  array_merge($basePattern, self::$_config->Root);
            $instancePattern =array_merge($appPattern, self::$_config->Instances);
            $modulesPattern = array_merge($basePattern, self::$_config->Instances);

            $array= array();
            $tokens = (array)self::$_config->Tokens;

            switch($pattern) {
                case "base":
                    $array = $basePattern;
                    break;

                case "app":
                    $array = $appPattern;
                    break;

                case "instance":
                    $array = $instancePattern;
                    break;

                case 'modules':
                    $array = $modulesPattern;
            }

            return (array)Path::processPattern($array,$tokens);

        }

        /**
         * Instance dir
         * @param $a
         * @return mixed
         */
        static public function id($a){
            return self::$_instancePaths->getBaseDir()[$a];
        }
        static public function mu($a){
            return self::$_instancePaths->getBaseurl()[$a];
        }
        static public function getModuleBaseUrl($name) {
            return  self::mu('modules') . $name . "/";
        }
        static public function getModuleBaseDir($name) {
            return  self::$_instancePaths->getBaseDir()['modules'] . $name . "/";
        }

        static public function getModuleConfigPath($name) {
            $basePaths = self::getBasePaths("modules");
            return self::id('modules') . $name . "/". $basePaths['config'];
        }
        static public function getModuleAutoload($name) {
            $basePaths = self::getBasePaths("modules");
            return self::id('modules') . $name . "/". $basePaths['autoload'];
        }

        #endregion

        protected function themesPaths() {
            $dir = self::getBasePaths("app")['themes'];
            var_dump($dir);
        }

        protected function end() {
            parent::end();
        }

    }
}