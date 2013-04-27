<?php
namespace LibreMVC\Views;
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
 * @package   Views
 * @subpackage ViewBag
 * @copyright Copyright (c) 2005-2012 Inwebo (http://www.inwebo.net)
 * @license   http://http://creativecommons.org/licenses/by-nc-sa/3.0/
 * @version   $Id:$
 * @link      https://inwebo@github.com/inwebo/My.Sessions.git
 * @since     File available since Beta 01-01-2012
 */

/**
 * Conteneur global des variables nécessaire aux templates.
 * 
 * Singleton, permet d'éviter de polluer le namespace global avec les variables
 * des templates. C'est l'interface entre une vue & modéle. Toutes données qui
 * doivent être affichées devraient être définies dans le viewbag.
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
class ViewBag {

    /**
     * Instance unique du ViewBag
     *
     * @param object $instance contient l'instance courante.
     * @static
     */
    protected static $instance;

    /**
     * Constructeur privé.
     * Pattern singleton
     */
    private function __construct() {}

    /**
     * Retourne l'instance courante d'un objet singleton ViewBag
     *
     * @return ViewBag ViewBag courant
     * @static
     */
    public static function get() {
        if (!isset(self::$instance)) {
            $c = __CLASS__;
            self::$instance = new $c;
        }

        return self::$instance;
    }

    /**
     * Setter
     */
    public function __set($key, $value) {
        $this->$key = $value;
    }

    /**
     * Getter
     */
    public function __get($key) {
        if (isset($this->$key)) {
            return $this->$key;
        }
    }

}
