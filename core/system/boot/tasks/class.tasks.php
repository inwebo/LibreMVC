<?php
namespace LibreMVC\System\Boot {

    class Tasks extends \SplObjectStorage implements IStepable {

        protected $_name;

        function __construct($_name) {
            $this->_name = $_name;
        }
    }
}