<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 01/09/13
 * Time: 22:41
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Html\Helpers;

use LibreMVC\Files\Config;
use LibreMVC\Http\Context;
use LibreMVC\Mvc\Environnement;
use LibreMVC\System\Hooks;

class Theme {


    protected $_name;
    protected $_description;
    protected $_version;
    protected $_core;
    protected $_paths;
    protected $_css;
    protected $_js;

    public function __construct( Config $config, $paths ) {
        $this->_name = $config->Informations->name;
        $this->_description = $config->Informations->description;
        $this->_version = $config->Informations->version;
        $this->_core = $config->Informations->core;
        $this->_paths = $paths;
        $this->_css = $this->newCss($config);
        $this->_js = $this->newJs($config);
    }

    protected function newCss($config) {
        if( isset($config->CoreCss) && isset($config->Css) ) {
            return array_merge((array)$config->CoreCss, (array)$config->Css);
        }
        elseif( !isset($config->CoreCss) && isset($config->Css) ) {
            return $config->Css;
        }
        else {
            return array();
        }
    }

    protected function newJs($config) {
        if( isset($config->CoreJs) && isset($config->Js) ) {
            return array_merge((array)$config->CoreJs, (array)$config->Js);
        }
        elseif( !isset($config->CoreJs) && isset($config->Js) ) {
            return $config->Js;
        }
        else {
            return array();
        }
    }

    public function getSrc() {
        $buffer = array();
        foreach($this->_js as $v) {
            $buffer[] = $this->_paths->theme_baseUrl_js . $v ;
        }
        return $buffer;
    }

    public function getThemesJsSrc() {
        $buffer = array();
        foreach($this->_js as $v) {
            $buffer[] = $this->_paths->theme_baseUrl_js . $v ;
        }
        return $buffer;
    }

    public function getHref() {
        $buffer = array();
        foreach($this->_css as $v) {
            $buffer[] = $this->_paths->theme_baseUrl_css . $v ;
        }
        return $buffer;
    }

    public function getThemesCssHref() {
        $buffer = array();
        foreach($this->_css as $v) {
            $buffer[] = $this->_paths->theme_baseUrl_css . $v ;
        }
        return $buffer;
    }

    protected function cssToString() {
        $buffer = "";
        foreach($this->_css as $v) {
            $buffer .= "<link rel='stylesheet' type='text/css' href='";
            $buffer .= $this->_paths->theme_baseUrl_css . $v ;
            $buffer .= "' >'";
        }
        return $buffer;
    }

    protected function jsToString() {
        $buffer = "";
        foreach($this->_js as $v) {
            $buffer .= "<script type='text/javascript' src='";
            $buffer .= $this->_paths->theme_baseUrl_js . $v ;
            $buffer .= "' >'";
        }
        return $buffer;
    }

    public function toString($type = 'both') {
        switch($type) {
            case 'both':
                return $this->cssToString() . $this->jsToString();
                break;
            case 'css':
                return $this->cssToString() ;
                break;
            case 'js':
                return $this->jsToString();
                break;
        }
    }
}