<?php

namespace LibreMVC\Form;

use LibreMVC\Html\Tag as Tag;
/**
 * @link http://www.w3.org/html/wg/drafts/html/master/single-page.html#the-fieldset-element W3C
 */
class Fieldset extends Tag {

    public $tag = "fieldset";

    public function __construct($attributs = array(), $dataAttributs = array()) {
        parent::__construct();
        $this->attributs = $this->buildAttributs($attributs, __CLASS__);
        $this->dataAttributs = $dataAttributs;
    }

}
