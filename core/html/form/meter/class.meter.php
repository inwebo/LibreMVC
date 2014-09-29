<?php

namespace LibreMVC\Form;

use LibreMVC\Html\Tag as Tag;
/**
 * @package LibreMVC
 */
class Meter extends Tag {

    protected $tag = "meter";
    protected $selfClosingTag = false;
    public $allowDescendants = false;

    public function __construct($attributs = array(), $dataAttributs = array()) {
        parent::__construct();
        $this->attributs = $this->buildAttributs($attributs, __CLASS__);
        $this->dataAttributs = $dataAttributs;
    }

    static protected function getLocalAttributs() {
        return array(
            "value" => "",
            "max" => ""
        );
    }

}