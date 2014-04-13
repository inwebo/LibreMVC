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

    static public function map($object) {
        $_this = new self;
        foreach($object as $k => $v) {
            $_this->$k = $v;
        }
        return $_this;
    }

    public function strongTypedView($viewFile) {
        ob_start();
        include($viewFile);
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
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

}
