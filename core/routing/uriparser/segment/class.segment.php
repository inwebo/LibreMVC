<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 11/08/13
 * Time: 22:31
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Routing\UriParser;


class Segment {

    public $segment;
    public $dataIn;
    public $isNamed;
    public $name;
    public $isTyped;
    public $type;
    public $regex;
    public $validateType;
    public $valid = false;

    public function __construct( $segment, $dataIn ) {
        $this->segment          = trim( $segment, '[]' );
        $this->dataIn           = $dataIn;
        $this->isNamed          = $this->isNamed();
        $this->name             = ( $this->isNamed() ) ? $this->getName()      : null;
        $this->isTyped          = $this->isTyped();
        $this->type             = ( $this->isTyped )   ? $this->getType()      : null ;
        $this->validateType     = ( $this->isTyped() ) ? $this->validateType() : null ;
        $this->valid            = $this->isValid();
    }

    protected function isNamed() {
        return ( strpos(  $this->segment, ':id|' ) !== false ) ? true :false;
    }

    protected function getName() {
        $name = explode( '|', $this->segment );
        if($this->isTyped()) {
            $name[1] = preg_replace('#\(.*\)#','',$name[1]);
        }
        if($this->isRegex()) {
            $name[1] = preg_replace('#\#(.*)\##','',$name[1]);
        }
        return $name[1];
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
                preg_match_all("#\#(.*)\##", $this->segment, $match);
                $result = preg_match($match[0][0], $this->dataIn);
                $this->regex = $match[0][0];
                return ($result === 0) ? false : true;
                break;
        }
    }

    protected function betweenChar( $char, $segment ) {
        $pos   = array();
        $pos[] = strpos($this->segment, $char[0]);
        $pos[] = strpos($this->segment, $char[1]);
        return substr( $this->segment, $pos[0] + 1, ( $pos[1] - $pos[0] ) -1 );
    }

    protected function isRegex() {
        return preg_match("#\#(.*)\##", $this->segment);
    }

    protected function isValid() {
        return $this->validateType ;
    }

}