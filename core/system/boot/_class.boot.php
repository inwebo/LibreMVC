<?php

namespace LibreMVC\System {

    use LibreMVC\System;
    use LibreMVC\System\Boot\IBootable;

    class _Boot {

        protected $_steps;
        protected $_dataProvider;

        public function __construct( IBootable $steps, $dataProvider ) {
            if( is_object( $steps ) ) {
                $this->_steps = $steps;
                $this->_dataProvider = $dataProvider;
                $this->start();
            }
            else {
                throw new \Exception( __CLASS__ . ' must have valid callback object');
            }
        }

        public function start() {
            $members = get_class_methods( $this->_steps );
            foreach( $members as  $member ) {
                $reflectAssertions = new \ReflectionMethod( $this->_steps, $member );
                if($reflectAssertions->isStatic() && $reflectAssertions->isPublic()) {
                    $val = $reflectAssertions->invoke($member);
                    if( !is_null($val) ) {
                        $this->_dataProvider->$member = $val;
                    }
                }
            }
        }

    }
}