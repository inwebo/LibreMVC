<?php
namespace LibreMVC\View;

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
class ViewObject extends StdClass{

    public function propertyExists($property) {

    }

    public function isIterableMember($property) {
        return (bool)is_array($property) || $property instanceof \Traversable;
    }

    public function isMember( $property ) {
        return isset($this->$property);
    }



}
