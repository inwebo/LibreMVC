<?php
/**
 * Created by JetBrains PhpStorm.
 * User: julien
 * Date: 20/08/13
 * Time: 13:28
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Html\Helpers;

use LibreMVC\System\Singleton;

class Includer extends Singleton {

    public $assets;
    public $type;

    protected function __construct() {
        $this->assets = new \StdClass();
    }

    protected function isValidAsset( $file ) {
        return is_file($file);
    }


    public function getType( $slashes = true ) {
        return ( $slashes ) ? '/' . $this->type . '/' : $this->type;
    }
}