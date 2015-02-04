<?php

namespace LibreMVC\System\Boot\Tasks {

    use LibreMVC\Files\Config;
    use LibreMVC\Http\Request;
    use LibreMVC\Patterns\Observer\Observable;
    use LibreMVC\Routing\Route;
    use LibreMVC\System\Boot\Tasks\Task\Instance;
    use LibreMVC\System\Boot\Tasks\Task\Paths;
    use LibreMVC\View;
    use LibreMVC\View\ViewObject;

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
         * @var Paths
         */
        static protected $_basePaths;
        /**
         * @var Paths
         */
        static protected $_appPaths;
        /**
         * @var Instance
         */
        static protected $_instance;
        /**
         * @var Paths
         */
        static protected $_instancePaths;
        /**
         * @var \AdjustablePriorityQueue
         */
        static protected $_modulesQueue;
        /**
         * @var array[Modules]
         */
        static protected $_modules;
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

        protected function end(){
            $this->_statement ="ended";
            $this->notify();
        }
    }
}