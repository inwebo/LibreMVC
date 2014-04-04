<?php

namespace LibreMVC;

use LibreMVC\View\Template;
use LibreMVC\View\ViewObject;
use LibreMVC\View\Parser;

/**
 * Class View
 * @package LibreMVC
 */
class View {

    public $viewObject;
    protected $_template;
    protected $_parser;
    protected $_autoRender = true;

    public function __construct( Template $template, ViewObject $viewObject ) {
        try {
            $this->_template = $template;
            $this->viewObject = $viewObject;
        }
        catch(\Exception $e) {
            var_dump($e);
        }
    }

    public function isAutoRender( $bool = null ) {
        if(is_null($bool)){
            return $this->_autoRender;
        }
        else {
            if(is_bool($bool)) {
                $this->_autoRender = $bool;
            }
        }
    }

    public function render() {
        $this->_parser = new Parser($this->_template, $this->viewObject);
        if( $this->_autoRender ) {
            echo $this->_parser;
        }
        else {
            return $this->_parser;
        }
    }

    static public function partial( $path, ViewObject $viewObject = null ) {
        if(is_null($viewObject)) {
            return new self( new Template($path), new  ViewObject());
        }
        else {
            return new self( new Template($path), $viewObject );
        }
    }

}