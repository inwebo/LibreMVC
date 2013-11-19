<?php

namespace LibreMVC\Html\Document;

use LibreMVC\Database\Entity;

class Head extends Entity{

    protected  $id;
    public $uri;
    public $md5;
    public $base;
    public $title;
    public $description;
    public $keywords;
    public $baseUrl;

}