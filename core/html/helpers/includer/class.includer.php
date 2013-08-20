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

    protected function __construct() {
        $this->assets = new \StdClass();
    }

    protected function isValidAsset( $file ) {
        echo __METHOD__;
        return is_file($file);
    }

    public function __set($key, $value) {
        echo __METHOD__;
        if($this->isValidAsset($value)) {
            $this->assets->$key = $value;
        }
    }

}