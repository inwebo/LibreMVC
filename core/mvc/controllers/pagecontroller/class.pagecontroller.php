<?php
namespace LibreMVC\Mvc\Controllers;



/**
 * LibreMVC
 *
 * LICENCE
 *
 * You are free:
 * to Share ,to copy, distribute and transmit the work to Remix —
 * to adapt the work to make commercial use of the work
 *
 * Under the following conditions:
 * Attribution, You must attribute the work in the manner specified by
 * the author or licensor (but not in any way thant suggests that they
 * endorse you or your use of the work).
 *
 * Share Alike, If you alter, transform, or build upon
 * this work, you may distribute the resulting work only under the
 * same or similar license to this one.
 *
 *
 * @category  LibreMVC
 * @package   Controllers
 * @subpackage RootController
 * @copyright Copyright (c) 2005-2012 Inwebo (http://www.inwebo.net)
 * @license   http://http://creativecommons.org/licenses/by-nc-sa/3.0/
 * @version   $Id:$
 * @link      https://inwebo@github.com/inwebo/My.Sessions.git
 * @since     File available since Beta 01-01-2012
 */

/**
 * Tous les controllers de l'application devraient hérités de RootController.
 *
 * @category   LibreMVC
 * @package    RootControllers
 * @copyright  Copyright (c) 1793-2222 Inwebo Veritas (http://www.inwebo.net)
 * @license    http://framework.zend.com/license   BSD License
 * @version    $Id:$
 * @link       https://github.com/inwebo/Template
 * @since      File available since Beta
 * @author     Inwebo Veritas <inwebo@gmail.com>
 * @abstract
 */
use LibreMVC\Html\Document\Head;
use LibreMVC\Views\Template\ViewBag;
use LibreMVC\Mvc\Environnement;
abstract class PageController {

    protected $_viewbag;

    protected $_meta;

    /**
     * 
     */
    public function __construct() {
        $this->_viewbag = ViewBag::get();
        Head::orm(Environnement::this()->_dbSystem, 'heads', 'md5');
        $head = Head::getById( md5( Environnement::this()->instance->url ) );
        if($head === false) {
            $head = new Head(Environnement::this()->instance->url,'welcome');
        }
        $this->_meta = $head;
        $this->_viewbag->meta = $this->_meta;
    }

    /**
     * Action par défaut du controller devrait être surchargée.
     */
    public function indexAction() {}

    /**
     * Setter
     * @param string $member
     * @param string $value
     */
    public function __set($member, $value) {
        $this->$member = $value;
    }

    public function toMenuEntries() {
        $class = new \ReflectionClass($this);
        $methods = $class->getMethods(\ReflectionMethod::IS_PUBLIC);
        $j=-1;
        while(isset($methods[++$j])) {
            if(!strpos($methods[$j],'Action') ) {
                unset($methods[$j]);
            }
            else {
                $methods[$j] = str_replace('Action','', $methods[$j]->name);
            }
        }
        return (object)$methods;
    }

    /**
     * Getter
     * @param string $attribut
     * @return Mixed
     */
    public function __get($attribut) {
        if (property_exists($this, $attribut)) {
            return $this->$attribut;
        }
    }

    public  function __destruct() {
        $this->_meta->save();
    }

}
