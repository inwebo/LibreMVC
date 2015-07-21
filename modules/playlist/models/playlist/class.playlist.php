<?php

namespace LibreMVC\Modules\Playlist\Models {


    use LibreMVC\Database\Entity;

    class Playlist extends Entity{

        const SQL_TABLE_SONGS = "Songs";

        public $id;
        public $name;

        /**
         * @var \ArrayIterator
         */
        protected $_songs;

        public function init() {
            $conf = static::$_entityConfiguration;
            $conf->driver->toObject("\\LibreMVC\\Modules\\Playlist\\Models\\Song");
            $this->_songs = $conf->driver->query("SELECT S.id, S.title FROM ".self::SQL_TABLE_SONGS." AS S JOIN ".$conf->table." as P WHERE P.id = ?",array($this->id))->all();
            //var_dump($this->_songs->count());
        }

        public function getSongs(){
            return $this->_songs;
        }

    }
}