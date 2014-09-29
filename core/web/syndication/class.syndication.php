<?php

namespace LibreMVC\Web;


class Syndication {

    protected $domDocument;

    protected $meta;

    public function __construct( $_xmlVersion  = '1.0', $_xmlEncoding = 'utf-8' ){
        // Préparation du domDucoment
        $this->domDocument = new \DOMDocument($_xmlVersion, $_xmlEncoding);
        $this->domDocument->formatOutput = true;
    }



}