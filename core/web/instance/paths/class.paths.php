<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 01/05/13
 * Time: 00:48
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Web\Instance;

use LibreMVC\Files\Config;

class Paths {

    protected $_config;

    public function __construct( $config ) {
        $this->_config = $config;
    }

    public function  processBasePath( $placeHolders, $patterns ) {
        $processed = array();

        foreach($patterns as $k => $pattern) {
            $processed[$k] = $this->placeHolderCallback($pattern, $placeHolders);
        }

        return (object)$processed;

    }

    protected function placeHolderCallback( $stringToProcess, $patterns ) {
        $treePool = $patterns;
        $search = array_keys($treePool);
        $replace = array_values($treePool);
        return str_replace($search, $replace, $stringToProcess);
    }

}