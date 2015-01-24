<?php

namespace LibreMVC\Autoloader {

    class Handler implements IAutoloadable{

        protected $_classInfos;

        static protected $_decorators = array();

        public function __construct(ClassInfos $classInfos){
            $this->_classInfos = $classInfos;
            $this->load($this->_classInfos);
        }

        public function load(ClassInfos $classInfos){
            foreach(self::$_decorators as $decorator) {
                if($decorator->load($classInfos)) {
                    if( !class_exists( $classInfos->toAbsolute() ) ) {
                        include($decorator->toPath());
                    }
                }
            }
        }

        static public function addDecorator( IAutoloadable $decorator ){
            self::$_decorators[] = $decorator;
        }

        static public function handle($class){
            try{
                $c = new ClassInfos($class);
            }
            catch(\Exception $e) {
                var_dump($e);
            }
            return new self($c);
        }

    }
}