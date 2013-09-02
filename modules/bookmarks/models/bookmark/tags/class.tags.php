<?php
namespace LibreMVC\Modules\Bookmarks\Models\Bookmark;
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Tags {

    public $rawData;
    public $data;
    public $buffer;
    public $count;

    public function __construct( $_data ) {
        $this->rawData = $_data;
        $this->data = $this->cleanInput();
        $this->buffer = explode( ' ', trim( $this->data ) );
        $this->count = count( $this->buffer );
    }

    public function cleanInput() {
        $cleaned= preg_replace("#,+#",' ',$this->rawData);
        return preg_replace("#( )+#",' ',$cleaned);
    }

    public function toArray() {
		return $this->buffer;
    }
	
	public function toString( $glue = " "){
		return implode( $glue, $this->buffer );
	}

}

?>
