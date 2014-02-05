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

    protected $_paths;
    protected $_name;
    protected $_description;
    protected $_version;
    protected $_core;
    protected $_css;
    protected $_js;
    protected $_config;

    public function __construct( $paths ) {
        $this->_paths    = $paths;
        $this->_config   = Config::load($this->autoloaderRealPath, true);
        $this->_css      = new \StdClass();
        $this->_js       = new \StdClass();
    }

    public function isValidTheme() {
        return is_file( $this->_paths->theme_realPath_ini );
    }

    public function getCssUrls() {

    }

    public function getJsUrls() {

    }

}