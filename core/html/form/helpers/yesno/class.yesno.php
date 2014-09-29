<?php

namespace LibreMVC\Form\Helpers;

class YesNo extends FormNode {

    public function __construct() {
        $this->childs = new FormGroup("radio", 2);
        $this->childs->descendants[0]->label['after'] = "Yes";
        $this->childs->descendants[0]->setAttributs(array('value' => "true"));
        $this->childs->descendants[1]->label['after'] = "No";
        $this->childs->descendants[1]->setAttributs(array('value' => "false"));
    }

    public function display() {
        echo $this->childs;
    }

    public function getGroup() {
        return $this->childs;
    }

}
