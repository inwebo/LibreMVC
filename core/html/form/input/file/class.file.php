<?php
namespace LibreMVC\Form\Input;
/**
 * @link http://www.w3.org/html/wg/drafts/html/master/single-page.html#file-upload-state-(type=file) W3C
 */
class File extends FormInput {

	public function __construct( $params = array("readOnly" => NULL, "disabled" => NULL, "accept" => NULL, "maxlength" => NULL ) ) {
		parent::__construct();
		$this->baseAttributs["type"] = "file";
		$this->adddAttributs = array(
			"readonly"=>$params["readOnly"],
			"disabled"=>$params["disabled"],
			"accept"=>$params["accept"],
			"maxlength"=>$params["maxlength"],
		);

		unset($this->attributs['value']);
		$this->buildAttributs();
	}
}
