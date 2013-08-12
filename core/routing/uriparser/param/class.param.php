<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 11/08/13
 * Time: 22:31
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Routing\UriParser;


class Param {

    public $segment;
    public $dataIn;
    public $isNamed;
    public $name;
    public $isTyped;
    public $type;
    public $validateType;
    public $isSpelled;
    public $spelling;
    public $validateSpelling;
    public $valid = false;

    public function __construct( $segment, $dataIn ) {
        $this->segment = trim($segment,'[]');
        $this->dataIn = $dataIn;
        $this->isNamed = $this->isNamed();
        $this->name = ($this->isNamed()) ? $this->getName() : null;
        $this->isTyped = $this->isTyped();
        $this->type = ($this->isTyped) ? $this->getType() : null ;
        $this->validateType = ( $this->isTyped() ) ? $this->validateType() : null ;
        $this->isSpelled = $this->isSpelled();
        $this->spelling = ($this->isSpelled) ? $this->getSpelling() : null;
        $this->validateSpelling = ($this->isSpelled) ? $this->validateSpelling() : null ;
        $this->valid = $this->isValid();
    }

    protected function isNamed() {
        return ( strpos(  $this->segment, ':id|' ) !== false ) ? true :false;
    }

    protected function getName() {
        $r = explode( '|', $this->segment );
        return $r[1];
    }

    protected function isTyped() {
        return preg_match("#\({1}(.*)\){1}#", $this->segment);
    }

    protected function getType() {
        return $this->betweenChar(array('(',')'), $this->segment);
    }

    protected function validateType() {
        switch( $this->type ) {
            case 'int':
                return !preg_match('#[a-zA-Z]#', $this->dataIn);
                break;

            case 'regex':

                break;
        }
    }

    protected function getSpelling() {
        return $this->betweenChar(array('{','}'), $this->segment);
    }

    protected function betweenChar( $char, $segment ) {
        $pos   = array();
        $pos[] = strpos($this->segment, $char[0]);
        $pos[] = strripos($this->segment, $char[1]);
        return substr( $this->segment, $pos[0] + 1, ( $pos[1] - $pos[0] ) -1 );
    }

    protected function isSpelled() {
        return preg_match("#{(.*)}#", $this->segment);
    }

    protected function validateSpelling() {
        return preg_match($this->spelling, $this->dataIn);
    }

    protected function isValid() {
        $validateType = (is_null($this->type)) ? true : $this->type;
        $validateSpelling = (is_null($this->validateSpelling)) ? true : $this->validateSpelling;
        return $validateType && $validateSpelling ;
    }

}