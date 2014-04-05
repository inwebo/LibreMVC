<?php

namespace LibreMVC;

use LibreMVC\View\Interfaces\IDataProvider;
use LibreMVC\View\Template;
use LibreMVC\View\ViewObject;
use LibreMVC\View\Parser;

/**
 * Class View
 * @package LibreMVC
 */
class View {

    public $vo;
    protected $_template;
    protected $_parser;
    protected $_autoRender = true;

    public function __construct( Template $template, ViewObject $viewObject ) {
        try {
            $this->_template = $template;
            $this->vo = $viewObject;
        }
        catch(\Exception $e) {
            var_dump($e);
        }
    }

    /**
     * Est nécessaire pour avoir le contexte $this d'une vue dans un fichier parsé.
     */
    protected function setViewContext() {
        $content = $this->vo->strongTypedView($this->_template->getFile());
        $this->_template->set($content);
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
        $this->setViewContext();
        $this->_parser = new Parser($this->_template, $this->vo);
        if( $this->_autoRender ) {
            echo $this->_parser;
        }
        else {
            return $this->_parser;
        }
    }

    static public function partial( $path, IDataProvider &$viewObject = null ) {
        if(is_null($viewObject)) {
            return new self( new Template($path), new  ViewObject());
        }
        else {
            return new self( new Template($path), $viewObject );
        }
    }

}