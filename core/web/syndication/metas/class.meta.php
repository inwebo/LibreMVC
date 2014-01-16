<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 13/01/14
 * Time: 23:00
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Web\Syndication;

/**
 * Class Metas
 *
 * Contient les metas informations d'un element
 *
 * @package LibreMVC\Web\Syndication
 */
class Metas {

    public function __set($key, $value) {
        if( isset($this->$key)) {
            $this->$key = $value;
        }
    }
}