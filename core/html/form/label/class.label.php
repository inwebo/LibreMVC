<?php

namespace LibreMVC\Form;

use LibreMVC\Html\Tag as Tag;

class Label extends Tag {
    
    protected $tag = "label";
    public $innerHtml;
    public $allowDescendants = false;


    public function __construct($innerHtml = null, $attributs = array(), $dataAttributs = array()) {
        parent::__construct();
        $this->attributs = $this->buildAttributs($attributs, __CLASS__);
        $this->innerHtml = ( is_null($innerHtml) ) ? self::getId() : $innerHtml;
        $this->dataAttributs = $dataAttributs;
    }
    
    static protected function getLocalAttributs() {
        return array(
            "for" => "",
            "form" => ""
        );
    }
    
}