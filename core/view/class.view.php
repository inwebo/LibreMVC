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

    public function __construct( $pathToTemplate ) {
        try {
            $this->_template = new Template($pathToTemplate);
            $this->viewObject = new ViewObject();
        }
        catch(\Exception $e) {
            var_dump($e);
        }
    }

    public function setAutoRender( $bool ) {
        $this->_autoRender = $bool;
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

    public function partial( $path ) {
        return new self( $path );
    }

}