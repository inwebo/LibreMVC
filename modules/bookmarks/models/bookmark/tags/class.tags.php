<?php
namespace LibreMVC\Modules\Bookmarks\Models\Bookmark;

class Tags {

    protected $_rawInput;
    protected $_input;
    protected $_tags;
    protected $_count;

    /**
     * @param $inputString
     */
    public function __construct( $inputString ) {
        $this->_rawInput    = $inputString;
        $this->_input       = $this->cleanInput();
        $this->_tags        = explode( ' ', trim( $this->_input ) );
        $this->_count       = count( $this->_tags );
    }

    /**
     * @return mixed
     */
    protected function cleanInput() {
        $cleaned= preg_replace("#(,)+#",' ',$this->_rawInput);
        $cleaned= preg_replace("#-+#",' ',$cleaned);
        $cleaned= preg_replace("#'+#",' ',$cleaned);
        $cleaned= preg_replace("#\+#",' ',$cleaned);
        $cleaned= preg_replace("#(\(|\))+#",' ',$cleaned);
        $cleaned= preg_replace("#(<[a-zA-z]*>)+#",' ',$cleaned);
        return preg_replace("#( )+#",' ',$cleaned);
    }

    public function toArray(){
        $t = $this->_tags;
        $t = array_map('strtolower', $t);
        $t = array_flip($t);
        $t = array_flip($t);
        asort($t);
        return $t;
    }

    public function count() {
        return $this->$_count;
    }

	public function toString( $glue = " "){
		return implode( $glue, $this->_tags );
	}

}
