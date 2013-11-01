<?php

namespace LibreMVC\Html\Document;

use LibreMVC\Database\Entity;

class Head extends Entity{

    //public $id;
    public $uri;
    public $md5;
    public $base;
    public $title;
    public $description;
    public $keywords;

    public function __construct( $uri, $title, $description = '', $keywords = '', $base = null) {
        $this->uri = $uri;
        $this->md5 = md5($this->uri);
        $this->title = $title;
        $this->description = $description;
        $this->keywords = $keywords;
        $this->base = $base;
    }

}