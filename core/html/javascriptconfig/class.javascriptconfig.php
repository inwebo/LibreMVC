<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 03/11/13
 * Time: 16:09
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Html;


class JavascriptConfig {

    protected $_namespace;
    protected $_config;

    public function __construct( $namespace, $config = null ) {
        $this->_namespace = $namespace;
        $this->_config = $config;
    }

    protected function newNamespace( $namespaces ) {
        if( is_array($namespaces) ) {
            foreach($namespaces as $v) {
                $this->newNamespace($v);
            }
        }
        else if (is_string($namespaces)) {
            $namespaces .= 'window.'.$namespaces . '=window.'. $namespaces. ' || new Object;' . "\n";
        }
        return $namespaces;
    }

    public function __toString() {
        $string = '<script type=text/javascript>'."\n";
        // @todo pourquoi les accolades ne sont pas retournés
        //$string .= 'window.'.$this->_namespace . '=window.'.$this->_namespace . ' || {};' . "\n";
        $string .= 'window.'.$this->_namespace . '=window.'.$this->_namespace . ' || new Object;' . "\n";
        $string .= "window.".$this->_namespace . ".Config=window.".$this->_namespace . ".Config || new Object;"."\n";
        $string .= 'window.'.$this->_namespace . '.Config.User=';
        $string .= json_encode( $this->_config );
        $string .= ';'."\n";
        $string .= '</script>'."\n";
        return $string;
    }

}