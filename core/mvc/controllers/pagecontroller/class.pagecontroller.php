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
use LibreMVC\Cache;
use LibreMVC\Html\Document\Head;
use LibreMVC\Views\Template\ViewBag;
use LibreMVC\Mvc\Environnement;
abstract class PageController {

    protected $_viewbag;

    protected $_meta;
    protected $_metaStart;
    protected $_metaEnd;

    protected $_cachable = false;
    protected $_cache;

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
        $this->_metaStart = clone $this->_meta;
        $this->_viewbag->meta = $this->_meta;
        $this->_viewbag->meta->baseUrl = Environnement::this()->instance->baseUrl;
        $this->_viewbag->menus = $this->toMenuEntries();
        if($this->_cachable) {
            $this->_cache = new Cache( array( 'path' => Environnement::this()->paths['base_cache'],
                                              'id'=>$this->formatFileCacheName())

            );
            $this->_cache->start();
        }
    }

    protected function formatFileCacheName() {
        $controller = strtolower(str_replace("\\",".",trim(Environnement::this()->controller, "\\")));
        $action     = strtolower(Environnement::this()->action);
        $params     = urlencode(serialize(Environnement::this()->params));
        $id         = md5( $controller.$action.$params );
        return $id . "-" . $controller ."-". $action ."-". $params ;
    }

    /**
     * Action par défaut du controller devrait être surchargée.
     */
    public function indexAction() {
        Views::renderAction();
    }

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

    private function isMetaUpToDate() {
        return $this->_meta === $this->_viewbag->_meta;
    }

    public function __destruct() {
        // Meta
        $this->_metaEnd = $this->_meta;
        if( ($this->_metaStart == $this->_metaEnd) === false ) {
            $this->_viewbag->meta = $this->_meta;
            $this->_meta->save();
        }

        if($this->_cachable) {

            $this->_cache->stop();
        }

        if(isset($this->breadcrumbs)) {
            Environnement::this()->BreadCrumbs =$this->breadcrumbs[1] ;
        }

    }

}
