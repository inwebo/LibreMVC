<?php

namespace LibreMVC\Form;

use LibreMVC\Html\Tag as Tag;

// @todo Labellable
/**
 * @link http://www.w3.org/html/wg/drafts/html/master/single-page.html#the-input-element W3C
 */
abstract class Input extends Tag {

    protected $tag = "input";
    protected $selfClosingTag = true;
    protected $allowDescendants = false;

    public function __construct($attributs = array(), $dataAttributs = array()) {
        parent::__construct();
        $this->attributs = $this->buildAttributs($attributs, __CLASS__);
        $this->dataAttributs = $dataAttributs;
    }

    static protected function getLocalAttributs() {
        return array(
            "type" => "text",
            "size" => NULL,
            "readonly" => NULL,
            "disabled" => NULL,
            "alt" => NULL,
            "value" => NULL,
            "onchange" => NULL,
            "onselect" => NULL,
            "maxlength" => null,
            "value" => null,
            "pattern" => null
        );
    }

}
