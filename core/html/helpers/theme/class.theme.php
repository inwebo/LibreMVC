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

    private $_config;

    protected $_name;
    protected $_description;
    protected $_version;
    protected $_core;
    protected $_paths;

    public function __construct( Config $config, $paths ) {
        $this->_config = $config;
        $this->_paths = $paths;
        $this->_name = $config->Informations->name;
        $this->_description = $config->Informations->description;
        $this->_version = $config->Informations->version;
        $this->_core = $config->Informations->core;
    }

    public function getCoreJs() {
        $buffer = array();
        foreach($this->_config->CoreJs as $k => $v ){
            $buffer[] = $this->_config->BaseUrl['global_assets_js'] . $v;
        }
        return $buffer;
    }

    public function getCoreCss() {
        $buffer = array();
        foreach($this->_config->CoreCss as $k => $v ){
            $buffer[] = $this->_config->BaseUrl['global_assets_css'] . $v;
        }
        return $buffer;
    }

    public function getThemeCss() {
        $buffer = array();
        foreach($this->_config->Css as $k => $v ){
            $buffer[] = $this->_paths->theme_baseUrl_css . $v ;
        }
        return $buffer;
    }

    public function getThemeJs() {
        $buffer = array();
        foreach($this->_config->Js as $k => $v ){
            $buffer[] = $this->_paths->theme_baseUrl_js . $v ;
        }
        return $buffer;
    }

}