<?php

namespace LibreMVC\Html\Document;

use LibreMVC\Database\Entity;

class Head extends Entity{

    public $id;
    public $uri;
    public $md5;
    public $description;
    public $keywords;
    public $author;
    public $title;


    public function __construct( $uri, $title, $description = '', $keywords = '', $author ="inwebo") {
        parent::__construct();
        $this->uri = $uri;
        $this->md5 = md5($this->uri);
        $this->title = $title;
        $this->description = $description;
        $this->keywords = $keywords;
        $this->author = $author;
    }

}