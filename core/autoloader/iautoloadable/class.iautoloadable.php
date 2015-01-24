<?php
/**
 * Created by PhpStorm.
 * User: inwebo
 * Date: 20/01/15
 * Time: 01:00
 */

namespace LibreMVC\Autoloader {

    interface IAutoloadable {

        public function load(ClassInfos $classInfos);

    }
}