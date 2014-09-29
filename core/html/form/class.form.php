<?php

/**
 * Formulaire
 * @package LibreMVC
 * @subpackage Form
 */

namespace LibreMVC;

/**
 * @TEst
 */
use LibreMVC\Html\Tag as Tag;

class Form extends Tag {

    protected $tag = "form";

    public function __construct($attributs = array(), $dataAttributs = array()) {
        parent::__construct();
        $this->dataAttributs = $dataAttributs;
        $this->attributs = $this->buildAttributs($attributs, __CLASS__);
    }

    static protected function getLocalAttributs() {
        return array(
            "type" => "form",
            "action" => "?",
            "method" => "post",
            "enctype" => "application/x-www-form-urlencoded",
            "accept" => NULL,
            "target" => NULL,
            "accept-charset" => NULL,
            "onsubmit" => NULL,
            "onsreset" => NULL,
        );
    }

}
