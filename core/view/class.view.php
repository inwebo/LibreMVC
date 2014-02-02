<?php

namespace LibreMVC;

use LibreMVC\View\Template;
use LibreMVC\View\ViewObject;

/**
 * Class View
 * @package LibreMVC
 */
class View {

    public $viewObject;
    protected $_template;
    protected $_parser;
    protected $_autoRender = false;

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
        $this->_parser = new View\Parser($this->_template, $this->viewObject);
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