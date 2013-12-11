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
use LibreMVC\Mvc\Controllers;
use LibreMVC\Views\Template\ViewBag;
use LibreMVC\Mvc\Environnement;
abstract class PageController extends Controllers{

    protected $_viewbag;

    protected $_meta;
    protected $_metaStart;
    protected $_metaEnd;

    protected $_cachable = false;
    protected $_cache;

    protected $_breadCrumbs;

    /**
     * @todo Viewbag decrait être une instance
     */
    public function __construct() {
        $this->_viewbag = ViewBag::get();
        $this->prepareHeadMeta();
        $this->prepareCache();
        $this->prepareBreadcrumbs();
        $this->prepareViewBag();
    }

    protected function prepareCache() {
        if($this->_cachable) {
            $this->_cache = new Cache( array( 'path' => Environnement::this()->paths->base_cache,
                    'id'   => $this->formatFileCacheName())
            );
            $this->_cache->start();
        }
    }

    // Devrait être invoqué AVANT prepareViewBag()
    protected function prepareBreadcrumbs() {
        $this->_breadCrumbs = Environnement::this()->BreadCrumbs;
        $this->_breadCrumbs->items->home = Environnement::this()->instance->baseUrl ;
    }

    /**
     * Par défault le viewbag contient les informations meta.
     * 1 breadcrumbs
     * 1 menu
     */
    protected function prepareViewBag() {
        $this->_viewbag->meta = $this->_meta;
        $this->_viewbag->meta->baseUrl = Environnement::this()->instance->baseUrl;
        $this->_viewbag->menus = $this->toMenuEntries();
    }

    protected function prepareHeadMeta() {
        $uri = trim(Environnement::this()->instance->url, '/').'/';
        $uri = (strstr($uri, '?')) ? explode('?', $uri)[0]:$uri;
        $md5Uri = md5($uri);

        Head::binder(Environnement::this()->_dbSystem, 'heads', 'id');
        $head = Head::load( $md5Uri, 'md5' );

        if($head === false || is_null($head)) {
            $head = new Head();
            $head->uri = $uri;
            $head->md5 = md5($uri);
            $head->title = "Welcome!";
        }

        $this->_meta          = $head;
        $this->_metaStart     = clone $this->_meta;
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
     * @todo Trop de ressource
     * @return object
     */
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

    public function __destruct() {
        // Meta
        $this->_metaEnd = $this->_meta;
        //if( ($this->_metaStart == $this->_metaEnd) === false ) {
        if( ($this->_metaStart == $this->_metaEnd) === false ) {

            $this->_viewbag->meta = $this->_meta;
            $this->_meta->save();
        }

        if($this->_cachable) {
            $this->_cache->stop();
        }

        if( isset( $this->_breadCrumbs ) ) {
            Environnement::this()->BreadCrumbs = $this->_breadCrumbs;
            //var_dump($this->_breadCrumbs);
        }

    }

}
