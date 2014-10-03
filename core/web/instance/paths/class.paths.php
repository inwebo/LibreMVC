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
use LibreMVC\Mvc\Environnement;
use LibreMVC\System\Boot\Mvc;

class Paths {

    protected $_config;

    public $realPath;

    public $placeholders;
    public $replacements;

    public function __construct( Config $config ) {
        $this->_config = $config;
    }

    public function pushPlaceholder( $array ) {
        $this->placeholders = array_merge($this->placeholders,$array);
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

    public function processRealPath( $realPath = true ) {

    }

}