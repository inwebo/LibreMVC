<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 13/10/13
 * Time: 18:11
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Database\Driver;

/**
 * Class IDriver
 * @package LibreMVC\Database\Driver
 */
interface IDriver {
    public function getDriver();
    function getTableInfos($table);
}