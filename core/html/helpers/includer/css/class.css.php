<?php
/**
 * Created by JetBrains PhpStorm.
 * User: julien
 * Date: 20/08/13
 * Time: 13:30
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Html\Helpers\Includer;

use LibreMVC\Html\Helpers\Includer;

class Css extends Includer {

    public $type = "css";

    protected function __construct() {
        parent::__construct();
    }

}