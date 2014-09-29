<?php

namespace LibreMVC\Form\Input;

use LibreMVC\Form\Input as Input;

class Text extends Input {

    public function __construct($attributs = array(), $dataAttributs = array()) {
        parent::__construct();
        $this->attributs = $this->buildAttributs($attributs, __CLASS__);
        $this->dataAttributs = $dataAttributs;
    }

    static protected function getLocalAttributs() {
        return array();
    }

}
