<?php
namespace LibreMVC\View;

use LibreMVC\View\Interfaces\IDataProvider;
use \StdClass;
/**
 * Peut être un dataProvider
 * 
 * @category   LibreMVC
 * @package    Views
 * @subpackage ViewBag
 * @copyright  Copyright (c) 1793-2222 Inwebo Veritas (http://www.inwebo.net)
 * @license    http://framework.zend.com/license   BSD License
 * @version    $Id:$
 * @link       https://github.com/inwebo/Template
 * @since      File available since Beta
 * @static
 */
class ViewObject extends StdClass implements IDataProvider {

    /**
     * Views collection
     * @var \StdClass
     */
    protected $_partials;

    public function __construct(){
        $this->_partials = new \StdClass;
    }

    static public function map( $object ) {
        $_this = new self;
        foreach($object as $k => $v) {
            $_this->$k = $v;
        }
        return $_this;
    }

    /**
     * Permet d'obtenir le context $this dans la vue.
     *
     * @param $viewFile Un fichier à inclure.
     * @return string Le contenus parsé par PHP
     */
    public function strongTypedView( $viewFile ) {
        if( is_file($viewFile) ) {
            ob_start();
            include($viewFile);
            $content = ob_get_contents();
            ob_end_clean();
            return $content;
        }
        else {
            trigger_error(__CLASS__ . ' ' . __FUNCTION__ . ' ' . __LINE__ . ' ' . 'View file : ' . $viewFile . ' doesn\'t exists.');
        }
    }

    public function propertyExists($property) {
        return isset($this->$property);
    }

    public function isIterableMember($property) {
        return (bool)is_array($property) || $property instanceof \Traversable;
    }

    public function isMember( $property ) {
        return isset($this->$property);
    }

    public function attachPartial( $name, View $view ) {
        return ( $this->_partials->$name = $view );
    }

    public function removePartial( $name ) {
        if( isset($this->_partials->$name ) ) {
            unset( $this->_partials->$name );
        }
    }

    public function partial( $name ) {
        if( isset( $this->_partials->$name ) ) {
            return $this->_partials->$name;
        }
    }

    public function getPartials() {
        return $this->_partials;
    }
}
