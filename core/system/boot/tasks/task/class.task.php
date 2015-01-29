<?php

namespace LibreMVC\System\Boot\Tasks {

    use LibreMVC\Files\Config;
    use LibreMVC\Patterns\Observer\Observable;

    abstract class Task extends Observable {

        protected $_name;
        /**
         * @var string init|started|ended
         */
        protected $_statement;

        static protected $_request;
        static protected $_basePaths;
        static protected $_appPaths;
        static protected $_instance;
        static protected $_instancePaths;
        static protected $_modules;
        static protected $modules;
        static protected $_viewObject;
        static protected $_layout;
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