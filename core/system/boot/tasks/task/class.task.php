<?php

namespace LibreMVC\System\Boot\Tasks {

    use LibreMVC\Files\Config;
    use LibreMVC\Http\Request;
    use LibreMVC\Patterns\Observer\Observable;
    use LibreMVC\Routing\Route;
    //use LibreMVC\System\Boot\Tasks\Task\Instance;
    //use LibreMVC\System\Boot\Tasks\Task\Paths;
    use LibreMVC\View;
    use LibreMVC\View\ViewObject;
    use LibreMVC\Web\Instance\PathsFactory\Path;
    use LibreMVC\Web\Instance;

    abstract class Task extends Observable {

        protected $_name;
        /**
         * @var string init|started|ended
         */
        protected $_statement;

        /**
         * @var Request
         */
        static protected $_request;
        /**
         * @var Path
         */
        static protected $_basePaths;
        /**
         * @var Path
         */
        static protected $_appPaths;
        /**
         * @var Instance
         */
        static protected $_instance;
        /**
         * @var Path
         */
        static protected $_instancePaths;
        /**
         * @var \AdjustablePriorityQueue
         */
        static protected $_themesQueue;
        /**
         * @var array[LibreModule]
         */
        static protected $_modules;
        /**
         * @var array[Theme]
         */
        static protected $_themes;
        /**
         * @var ViewObject
         */
        static protected $_viewObject;
        /**
         * @var View
         */
        static protected $_layout;
        /**
         * @var Route
         */
        static protected $_routed;
        /**
         * @var Config
         */
        static protected $_config;

        /**
         * @var Retourne les fichiers par default.
         */
        static protected $_tokens;


        function __construct($_name="Task") {
            parent::__construct();
            $this->_name = $_name;
            $this->_statement = "init";
            $this->notify();
        }

        public function getName(){
            return $this->_name;
        }

        public function getStatement(){
            return $this->_statement;
        }

        protected function start(){
            $this->_statement ="started";
            $this->notify();
        }

        static public function getFilesFromConfig($conf) {
            $buffer = array();
            $buffer['autoload'] = $conf->Tokens['%autoload%'];
            $buffer['index'] = $conf->Tokens['%index%'];
            $buffer['config'] = $conf->Tokens['%config%'];
            $buffer['configDir'] = $conf->Tokens['%dir_config%'];
            return $buffer;
        }

        protected function end(){
            $this->_statement ="ended";
            $this->notify();
        }
    }
}