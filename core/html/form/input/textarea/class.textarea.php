<?php

namespace LibreMVC\Form;

use LibreMVC\Html\Tag as Tag;

class TextArea extends Input {

    protected $tag = "textarea";
    protected $selfClosingTag = false;
    public $allowDescendants = false;
    public $innerHtml;

    public function __construct($innerHtml = "Send", $attributs = array(), $dataAttributs = array()) {
        parent::__construct();
        $this->attributs = self::buildAttributs($attributs);
    }

    static protected function getLocalAttributs() {
        return array(
            "disabled" => $disabled,
            "readonly" => $readOnly,
            "alt" => $alt,
            "rows" => $rows,
            "cols" => $cols
        );
    }

}
