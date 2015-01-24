<?php

namespace LibreMVC\System\Boot {

    class Requirements implements IBootable{

        const PHP_VERSION = 5.4;

        static public function isValidPhpVersion() {
            $version = (float)substr(phpversion(), 0, 3);
            if(!($version >= (float)self::PHP_VERSION)) {
                trigger_error('Require at least php '. self::PHP_VERSION .', you ve got ' . PHP_VERSION);
                exit;
            }
        }

    }
}