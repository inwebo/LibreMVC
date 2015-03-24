<?php
/**
 * Created by PhpStorm.
 * User: inwebo
 * Date: 12/03/15
 * Time: 17:26
 */

namespace LibreMVC\Mvc\Controller\Traits;


use LibreMVC\Database\Driver\IDriver;

trait DataBase {

    protected $_driver;

    /**
     * @return IDriver
     */
    public function getDbDriver()
    {
        return $this->_driver;
    }
    public function query($queryString, $args){

    }
    /**
     * @param mixed $driver
     */
    public function setDbDriver($driver)
    {
        $this->_driver = $driver;
    }

}