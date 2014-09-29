<?php

class FormSelect extends FormNode {
	public function __construct() {
		parent::__construct();
		$this->baseAttributs ["type"] = "select";
		$this->buildAttributs();
		$this->selfClosingTag = FALSE;
		$this->htmlTag	      = "select";
		$this->selfClosingTag = false;
		$this->cleanObject();
	}
}
