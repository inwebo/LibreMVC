<?php
/**
 * Created by PhpStorm.
 * User: inwebo
 * Date: 25/01/15
 * Time: 23:53
 */

namespace LibreMVC\Modules\Playlist\Models;


use LibreMVC\Database\Entity;

class Playlist extends Entity{

    const SQL_SONGS_TABLE = "Songs";

    public $id;
    public $name;

    /**
     * @var \ArrayIterator
     */
    protected $_songs;

    public function init() {
        $conf = static::$_entityConfiguration;
        $conf->driver->toObject("\\LibreMVC\\Modules\\Playlist\\Models\\Song");
        $this->_songs = $conf->driver->query("SELECT S.id, S.title FROM Songs AS S JOIN ".$conf->table." as P WHERE P.id = ?",array($this->id))->all();
    }

    public function getSongs(){
        return $this->_songs;
    }

}