<?php
/**
 * Created by PhpStorm.
 * User: inwebo
 * Date: 25/01/15
 * Time: 23:53
 */

namespace LibreMVC\Modules\Playlist\Models;

use LibreMVC\Database\Entity;

class Song extends Entity{

    public $id;
    public $title;

    public $pathSrc;
    public $pathSpectrum;

    public $type;

    public $artist;
    public $album;

    protected $_moods = array();

    public function init() {
        $conf = static::$_entityConfiguration;
        $conf->driver->toObject("\\LibreMVC\\Modules\\Playlist\\Models\\Mood");
        $this->_moods = $conf->driver->query("SELECT M.id as 'id', M.name as 'name' FROM Moods M join Song_Moods SM ON M.id = SM.id_mood join Songs S ON S.id = SM.id_song where S.id = ?",array($this->id))->all();
    }

    public function getMoods(){
        return $this->_moods;
    }

}