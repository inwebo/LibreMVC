<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 13/10/13
 * Time: 11:12
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\System\Boot\Cli;


class Cli {

    static public function isSapi() {
        return (PHP_SAPI == 'cli');
    }

}