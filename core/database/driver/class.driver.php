<?php

namespace LibreMVC\Database;

use \stdClass;
use LibreMVC\Database;

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
 * @package   Database
 * @subpackage Driver
 * @copyright Copyright (c) 2005-2012 Inwebo (http://www.inwebo.net)
 * @license   http://http://creativecommons.org/licenses/by-nc-sa/3.0/
 * @version   $Id:$
 * @link      https://inwebo@github.com/inwebo/My.Sessions.git
 * @since     File available since Beta 01-01-2012
 */

/**
 * Container d'instance unique de connexion  valide à une base de donnée.
 * Chaque instance de connexion doit être configurées au préalable avec une
 * class de setup.
 * 
 * La classe implémente le design pattern singleton
 * 
 * <code>
 * // Exemple avec une connexion SQlite
 * $user = new lSQlite( 'db/db.sqlite3' );
 * $path = new lSQlite( 'db/db2.sqlite3' );
 * 
 * Driver::setup("user",  $user );<br>
 * Driver::setup("home", $path );<br>
 * 
 * Driver::get("user")->query('SELECT * FROM user');
 * </code>
 * 
 * @category   LibreMVC
 * @package    Database
 * @subpackage Driver
 * @copyright  Copyright (c) 1793-2222 Inwebo Veritas (http://www.inwebo.net)
 * @license    http://framework.zend.com/license   BSD License
 * @version    $Id:$
 * @link       https://github.com/inwebo/Template
 * @since      File available since Beta
 * @author     Inwebo Veritas <inwebo@gmail.com>
 */
class Driver {

    /**
     * Instances PDO valides nommées.
     * @var Database
     */
    static private $pool;

    /**
     * Private constructor
     */
    private function __construct() {}

    /**
     * Private magic methode
     */
    private function __clone() {}

    /**
     * Retourne une instance nommée PDO valid.
     * 
     * @param string $name
     * @return Mixed
     */
    static public function get($name) {
        if( isset(self::$pool->$name) ) {
            return self::$pool->$name;
        }
    }

    /**
     * Configure une instance PDO $setup ayant comme nom courant $name. $setup
     * doit étendre la classe abstraite LibreMVC\Database
     * @param type $name Nom de l'intance courante.
     * @param \LibreMVC\Database\Database $setup
     */
    static public function setup($name, $setup) {
        if (!isset(self::$pool) ) {
            self::$pool = new stdClass();
        }

        if (!isset(self::$pool->$name) && $setup instanceof Database) {
            self::$pool->$name = $setup;
        }
    }

}
