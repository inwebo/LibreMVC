<?php

namespace LibreMVC\System\Boot\Tasks\Task {

    use LibreMVC\System\Boot\Tasks\Task;
    use LibreMVC\Files\Config;
    use LibreMVC\Http\Request;
    use LibreMVC\Http\Url;
    use LibreMVC\System\Hooks;
    use LibreMVC\System\Hooks\Hook\BindedHook;

    class Init extends Task{

        public function __construct($config){
            parent::__construct();
            $this->_name ='Ini';
            self::$_config = Config::load($config);
        }

        protected function start() {
            parent::start();
        }

        protected function request() {
            return Request::this(Url::get());
        }

        protected function config() {
            return self::$_config;
        }

        protected function hooks(){
            $hooksName = array_keys(self::$_config->Hooks);
            $total = count($hooksName);
            for($i=0;$i<$total;++$i) {
                $name = $hooksName[$i];
                Hooks::this()->$name = new BindedHook($name);
            }
            return Hooks::this();
        }

        protected function end() {
            parent::end();
        }

    }
}