<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 30/04/13
 * Time: 22:19
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Autoloader;


class Loader {

    static public function load( $namespace ) {
        $ns = new Namespaces($namespace);
        if(is_file( $ns->toFilePath() )) {
            include( $ns->toFilePath() );
        }
    }

}