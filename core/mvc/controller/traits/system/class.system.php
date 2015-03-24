<?php

namespace LibreMVC\Mvc\Controller\Traits {

    use LibreMVC\System as Sys;

    trait System {

        /**
         * @var Sys
         */
        protected $_system;

        /**
         * @return Sys
         */
        public function getSystem()
        {
            return $this->_system;
        }

        /**
         * @param Sys $system
         */
        public function setSystem(Sys $system)
        {
            $this->_system = $system;
        }

    }
}