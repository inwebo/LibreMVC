<?php
namespace LibreMVC\Form\Input;
class Radio extends FormInput {

	public function __construct( $params = array("readOnly" => NULL, "disabled" => NULL, 'value' => NULL ) ) {
		parent::__construct();
		$this->baseAttributs["type"] = "radio";
		$this->addAttributs = array(
			"readonly"=>$params["readOnly"],
			"value"=>$this->itemId,
			"disabled"=>$params["disabled"]
		);

		$this->buildAttributs($this->addAttributs);
		unset($this->label);
		$this->label['after'] = $this->itemId;
		$this->cleanObject();
	}
}
