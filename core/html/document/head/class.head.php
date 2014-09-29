<?php

namespace LibreMVC\Html\Document;

use LibreMVC\Database\Entity;

class Head extends Entity{
    static public $_primaryKey;
    static public $_table;
    static public $_tableDescription;
    static public $_statement;
    private $_updated;
    protected  $id;
    public $uri;
    public $md5;
    public $base;
    public $title;
    public $description;
    public $keywords;
    public $baseUrl;

    public function __set($k,$v) {
            $this->_updated = true;
            $this->k = $v;
    }

    public function isEqual(Head $head) {
        return ( ( $this == $head ) === false );
        //return ( ( $this == $head ) === false );
    }

}