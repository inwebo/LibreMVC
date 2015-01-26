<?php
/**
 * Created by PhpStorm.
 * User: inwebo
 * Date: 25/01/15
 * Time: 23:53
 */

namespace LibreMVC\Modules\Playlist\Models;


use LibreMVC\Database\Entity;
use LibreMVC\Database\Temp\_Entity;

class Mood extends Entity{
    static public $_primaryKey;
    static public $_table;
    static public $_tableDescription;
    static public $_statement;
    protected $id;
    public $name;

}