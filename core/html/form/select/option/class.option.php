<?php

class FormOption extends FormNode {
	public function __construct() {
		parent::__construct();
		$this->baseAttributs ["type"] = "option";
		$this->buildAttributs();
		$this->selfClosingTag = FALSE;
		$this->htmlTag			= "option";
		$this->selfClosingTag = false;
		$this->addChilds($this->itemId);
		$this->cleanObject();
	}
}
