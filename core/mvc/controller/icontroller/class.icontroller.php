<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 01/02/14
 * Time: 23:03
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Mvc\Controller;


interface IController {
    public function hasAction( $action );
}