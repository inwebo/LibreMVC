<?php
namespace LibreMVC\Modules\Bookmarks\Models\Bookmark {

    class Tags {

        protected $_rawInput;
        protected $_input;
        protected $_delimiter;

        public function __construct( $inputString,$delimiter = " ") {
            $this->_rawInput    = $inputString;
            $this->_input       = $this->cleanInput();
            $this->_delimiter   = $delimiter;
        }

        /**
         * @return mixed
         */
        protected function cleanInput() {
            $cleaned= preg_replace("#(,)+#",' ',$this->_rawInput);
            $cleaned= preg_replace("#'+#",' ',$cleaned);
            $cleaned= preg_replace("#\++#",' ',$cleaned);
            $cleaned= preg_replace("#\.+#",' ',$cleaned);
            $cleaned= preg_replace("#\;+#",' ',$cleaned);
            $cleaned= preg_replace("#(\(|\))+#",' ',$cleaned);
            $cleaned= preg_replace("#(<[a-zA-z]*>)+#",' ',$cleaned);
            return preg_replace("#( )+#",' ',$cleaned);
        }

        public function toArray(){
            $t = explode( $this->_delimiter, trim( $this->_input ) );
            $t = array_map('strtolower', $t);
            $t = array_flip($t);
            $t = array_flip($t);
            asort($t);
            return $t;
        }

        public function count() {
            return count($this->toArray());
        }

        public function toString( $glue = " "){
            $array = $this->toArray();
            return implode( $glue, $array );
        }

    }
}
