<?php
namespace LibreMVC\Form\Input\Radio;
class Group  {
	public function __construct( $type = "radio", $number = 0 ) {
		$this->number=$number;
		$this->type = $type;
		$this->output = '';
		$this->childs = array();
		$this->build();
	}

	public function build() {
		$j = -1;
		while( $j < $this->number - 1 ) {
			(strtolower($this->type)==="radio") ? $object = new FormRadio() : $object = new FormCheckbox(); ;
			$object->setAttributs( array("name" => "temp") );
			$this->childs[]  = $object;
			$j++;
		}
	}

	public function setAttributs( $index, $params ) {
		if ( isset($this->childs[$index]) ) {
			$this->childs[$index]->setAttributs($params);
		}
	}

	public function __toString() {
		foreach( $this->childs as $key => $value ) {
			$this->output .= $value;
		}
		return $this->output ;
	}
}
