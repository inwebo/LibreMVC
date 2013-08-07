<?php

namespace LibreMVC;

class Errors {
    
    public $errno;
    public $errstr;
    public $errfile;
    public $errline;
    public $errcontext;
    
    public function __construct($errno, $errstr, $errfile, $errline, $errcontext) {
        $this->errno=$errno;
        $this->errstr = $errstr;
        $this->errfile = $errfile;
        $this->errline = $errline;
        $this->errcontext = $errcontext;
    }
    
    public function __toString() {
        $output = "";
        $output .= '
        <div>
            <h6>[' . $this->errno . '] '. self::errNoAsString($this->errno) .'</h6>
                <ul>
                    <li>'. $this->errstr .'</li>
                    <li> From '. $this->errfile .' at line : '.  $this->errline.'</li>
                    <li>
                        '. implode(', ',$this->errcontext) .'
                    <li>
                </ul>
        </div>
        ';
        return $output;
    }
    
    public function toCSV($separator=";") {
        $list = array( self::errNoAsString($this->errno), $this->errstr, $this->errfile, $this->errline, $this->errcontext);
        return implode($separator, $list) . PHP_EOL;
    }

    public function toJson() {
        return json_encode($this);
    }

    public function toXmlNode() {
        //@todo
    }

    public function toXmlFile() {
        $dom = new \DOMDocument('1.0','UTF-8');
    }

    public function toSerializablePHP() {
        return serialize($this);
    }

    static protected function errNoAsString( $errno ){
        
        switch($errno) {
            default:
            case 2:
                return 'E_WARNING';
                break;
            case 8:
                return 'E_NOTICE';
                break;
            case 156:
                return 'E_USER_ERROR';
                break;
            case 512:
                return 'E_USER_WARNING';
                break;
            case 1024:
                return 'E_USER_NOTICE';
                break;
            case 4096:
                return 'E_RECOVERABLE_ERRO';
                break;
            case 8191:
                return 'E_ALL';
        }
    
    }
}