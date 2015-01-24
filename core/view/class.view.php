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

    protected $vo;
    /**
     * @var View\Template
     */
    protected $_template;

    /**
     * @var View\Parser
     */
    protected $_parser;

    /**
     * @var bool
     */
    protected $_autoRender = true;

    /**
     * @param Template $template Un fichier a parser
     * @param ViewObject $viewObject Un IDataProvider
     */
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
     * @param Template $template
     */
    public function setTemplate(Template $template) {
        $this->_template = $template;
    }

    /**
     * Est nécessaire pour avoir le contexte $this d'une vue dans un fichier parsé.
     */
    protected function setViewContext() {
        $content = $this->vo->strongTypedView( $this->_template->getFile() );

        $this->_template->set( $content );
    }

    /**
     * Setter autorender.
     *
     * @param null $bool
     * @return bool
     */
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

    /**
     * @return Parser
     */
    public function render( $vo = null  ) {
        if( $vo ) {
            $this->vo = ViewObject::map($vo);
        }
        $this->setViewContext();
        $this->_parser = new Parser($this->_template, $this->vo);
        if( $this->_autoRender ) {
            echo $this->_parser;
        }
        else {
            return $this->_parser;
        }
    }

    public function getDataProvider() {
        return $this->vo;
    }

    /**
     * @param $path
     * @param IDataProvider $viewObject
     * @return View
     */
    static public function partial( $path, IDataProvider &$viewObject = null ) {
        if(is_null($viewObject)) {
            return new self( new Template($path), new  ViewObject());
        }
        else {
            return new self( new Template($path), $viewObject );
        }
    }

}