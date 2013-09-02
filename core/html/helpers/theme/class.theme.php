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

    public $name;
    public $url;
    public $realPath;
    public $baseUrls;
    protected $baseUrl;
    protected $default;
    protected $filePattern;
    protected $autoloader = "theme.ini";
    protected  $autoloaderRealPath;
    public $config;

    public $css;
    public $js;

    public function __construct( $filePattern, $baseUrl , $name = "", $default = "default") {
        $this->filePattern       = $filePattern;
        $this->default           = $default;
        $this->name              = (strlen($name) === 0) ? $this->default : $name;
        $this->baseUrl           = $baseUrl;
        $this->url               = $this->getUrl();
        $this->baseUrls          = $this->getBaseUrls();
        $this->realPath = Environnement::this()->instance->realPath . "themes/" . $this->name . "/" ;
        $this->autoloaderRealPath = $this->realPath . $this->autoloader;
        $this->config = Config::load($this->autoloaderRealPath, true);
        $this->css = new \StdClass();
        $this->js = new \StdClass();
        $this->processConfig();
    }

    public function isValidTheme() {
        return is_file( $this->autoloaderRealPath );
    }

    protected function getUrl() {
        $pattern = array('%theme_current%', '%base_url%');
        $replace = array ($this->name .'/',$this->baseUrl);
        return str_replace($pattern, $replace , $this->filePattern);
    }

    protected function getBaseUrls() {
        $baseUrls = new \StdClass();
        $baseUrls->css = $this->url . "css/";
        $baseUrls->js = $this->url . "js/";
        $baseUrls->assets = $this->baseUrl . "assets/";
        return $baseUrls;
    }

    protected function processConfig() {
        // Frameworks
        Hooks::get()->callHooks('prependCoreAssets');
        foreach($this->config->Core as $k => $v) {
            if( substr($k, 0,2) =='js' ) {
                //echo $this->baseUrls->assets . 'js/' . $v . "<br>";
                if(is_file(realpath(getcwd()) . "/assets/js/".$v)) {
                    $url = "<script type='text/javascript' src='". $this->baseUrls->assets . "js/" .$v . "' ></script>" . "\n";
                    $this->js->$k = $url;
                }
                //@todo est en ligne ?
            }
            elseif(substr($k, 0,3) =='css') {
                if(is_file(realpath(getcwd()) . "/assets/css/".$v)) {
                    $url = "<link rel='stylesheet' href='". $this->baseUrls->assets . "css/" .$v  . "' >" . "\n";
                    $this->css->$k = $url;
                }
            }
        }
        Hooks::get()->callHooks('appendCoreAssets');

        // instance
        Hooks::get()->callHooks('prependCss');
        foreach($this->config->Css as $k => $v) {
            //echo $this->realPath . "css/" . $v;
            if(is_file($this->realPath . "css/" . $v)) {
                $url = "<link rel='stylesheet' href='". $this->baseUrls->css . "".$v .  "' >" . "\n";
                $this->css->$k = $url;
            }
        }
        Hooks::get()->callHooks('appendCss');

        Hooks::get()->callHooks('prependJs');
        foreach($this->config->Js as $k => $v) {
            echo $this->realPath . "js/" . $v;
            if(is_file($this->realPath . "js/" . $v)) {
                $url = "<script type='text/javascript' src='". $this->baseUrls->js . "" .$v . "' ></script>" . "\n";
                $this->css->$k = $url;
            }
        }
        Hooks::get()->callHooks('appendJs');
    }

}