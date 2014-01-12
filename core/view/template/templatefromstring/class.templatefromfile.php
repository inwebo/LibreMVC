<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 13/01/14
 * Time: 00:26
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\View\Template;

class TemplateFromString extends Template{

    public function __construct($string) {
        $this->content = $string;
    }

}