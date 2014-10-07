<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 09/11/13
 * Time: 12:31
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\System\Boot;


class Requirements {

    const PHP_VERSION = 5.4;

    /**
     * Extensions
     *
     * PDO
     * pdo_mydsl
     * pdo_sqlite
     *
     */

    /**
     * Mods
     *
     * mod_rewrite
     */

    /**
     * Lecture ecriture groupe dans la db/ 0664
     */

    static public function isValidPhpVersion() {
        $version = (float)substr(phpversion(), 0, 3);
        if(!($version >= (float)self::PHP_VERSION)) {
            trigger_error('Require at least php '. self::PHP_VERSION .', you ve got ' . PHP_VERSION);
            exit;
        }
    }

    static public function isModRewriteEnable() {
        if( !function_exists( 'apache_get_modules' ) ) {
            // Parse chaine
            ob_start();
            phpinfo(INFO_MODULES);
            ob_end_clean();
            if(!strstr(ob_get_contents,'mod_rewrite')) {
                trigger_error('Require mod_rewrite ' . PHP_VERSION);
                exit;
            }
        }
        else {
            if(!in_array('mod_rewrite',apache_get_modules())) {
                trigger_error('Require mod_rewrite' . PHP_VERSION);
                exit;
            }
        }
    }

    static public function isPDOSqliteExtensionsEnable() {
        if( !in_array( 'pdo_sqlite' , get_loaded_extensions() ) ) {
            trigger_error('Require pdo_sqlite extension' . PHP_VERSION);
            exit;
        }
    }

    //static public function isValidCacheDir() {}

    //static public function isValidDb() {}

}