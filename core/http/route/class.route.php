<?php

namespace LibreMVC\Http;

use \Exception;
use LibreMVC\Database\Entity;


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
 * the author or licensor (but not in any way that suggests that they
 * endorse you or your use of the work).
 *
 * Share Alike, If you alter, transform, or build upon
 * this work, you may distribute the resulting work only under the
 * same or similar license to this one.
 *
 *
 * @category  LibreMVC
 * @package   Http
 * @subpackage Instance
 * @copyright Copyright (c) 2005-2012 Inwebo (http://www.inwebo.net)
 * @license   http://http://creativecommons.org/licenses/by-nc-sa/3.0/
 * @version   $Id:$
 * @link      https://inwebo@github.com/inwebo/My.Sessions.git
 * @since     File available since Beta 01-01-2012
 */

/**
 * Détermine le dossier de travail courant selon une url.
 * 
 * Simple extension de la class PHP PDO
 * @category   LibreMVC
 * @package    Http
 * @subpackage Route
 * @copyright  Copyright (c) 1793-2222 Inwebo Veritas (http://www.inwebo.net)
 * @license    http://framework.zend.com/license   BSD License
 * @version    $Id:$
 * @link       https://github.com/inwebo/Template
 * @since      File available since Beta
 */

Class Route extends Entity {

    /**
     * Url courante.
     *
     * @var String
     */
    public $md5;
    public $instance;
    public $uri;
    public $pattern = "{controller}/{action}/{params}";
    public $alias = "";
    public $controller = "default";
    public $action = "index";
    //public $params = "";
    
    public function __construct( $arrayArgs = NULL ) {
        parent::__construct();
        $this->driver = "routes";
        if ( !is_null( $arrayArgs ) ) {
            $this->instance = $arrayArgs['instance'];
            $this->uri = $arrayArgs['uri'];
            $this->pattern = $arrayArgs['pattern'];
            $this->alias = $arrayArgs['alias'];
            $this->controller = $arrayArgs['controller'];
            $this->action = $arrayArgs['view'];
            //$this->params = ( isset( $arrayArgs['params'] ) ) ? $arrayArgs['params'] : null;
            $this->md5 = self::getHash($this->instance,$this->action, $this->controller);
        } else {
            throw new Exception('Empty $arrayArgs');
        }
    }
    
    static public function getHash($instance, $action, $controller) {
        return md5($instance . $action . $controller);
    }

    static public function getRouteByHash($md5) {
        return \LibreMVC\Database\Driver::get('routes')->query('SELECT * FROM routes WHERE md5=?',array($md5));
    }

    static public function isRoute($md5) {
        $route = self::getRouteByHash($md5);
        return ( count($route) == 1 ) ? true : false ;
    }
    
    public function __set($attribut, $value) {
        $this->$attribut = $value;
    }

}
