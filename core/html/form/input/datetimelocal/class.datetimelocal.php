<?php

namespace LibreMVC\Form\Input;

use LibreMVC\Form\Input as Input;

/**
 * @link http://www.w3.org/html/wg/drafts/html/master/single-page.html#local-date-and-time-state-(type=datetime-local) W3C
 */
class DateTimeLocal extends Input {

    public function __construct($attributs = array(), $dataAttributs = array()) {
        parent::__construct();
        $this->attributs = $this->buildAttributs($attributs, __CLASS__);
        $this->dataAttributs = $dataAttributs;
    }

    static protected function getLocalAttributs() {
        return array(
            "type" => 'datetime-local',
            "min"=>null,
            "max"=>null,
            "step"=>null
        );
    }

}
