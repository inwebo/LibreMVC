<?php

namespace LibreMVC\Form\Fieldset;

use LibreMVC\Html\Tag as Tag;
/**
 * @link http://www.w3.org/html/wg/drafts/html/master/single-page.html#the-legend-element W3c editor's draft
 */
class Legend extends Tag {

    public $tag = "legend";
    public $allowDescendants = false;
    public $innerHtml;
    
    public function __construct($innerHtml = null, $attributs = array(), $dataAttributs = array()) {
        parent::__construct();
        $this->innerHtml = ( is_null($innerHtml) ) ? self::getId() : $innerHtml;
        $this->attributs = $this->buildAttributs($attributs, __CLASS__);
    }
    
}
