<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 11/08/13
 * Time: 16:58
 * To change this template use File | Settings | File Templates.
 */
//@todo
namespace LibreMVC\Models;


use LibreMVC\Database\Entity;

class Url extends Entity{

    public $id;
    public $md5;
    public $url;

    static public function getById() {

    }

}