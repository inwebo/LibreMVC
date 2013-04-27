<?php

namespace LibreMVC\Database\Driver;

use \PDO;
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
 * @subpackage MySQL
 * @copyright Copyright (c) 2005-2012 Inwebo (http://www.inwebo.net)
 * @license   http://http://creativecommons.org/licenses/by-nc-sa/3.0/
 * @version   $Id:$
 * @link      https://inwebo@github.com/inwebo/My.Sessions.git
 * @since     File available since Beta 01-01-2012
 */

/**
 * Création d'une connexion à une base de donnée SQLite. La base de donnée DOIT
 * être disponible en lecture, écriture.
 * 
 * <code>
 * <br>
 * $host = "localhost";<br>
 * $db = "mvc";<br>
 * $u = "root";<br>
 * $p ="root";<br>
 * // Exemple avec une connexion MySQL<br>
 * $mysql = new MySQL($host,$db, $u, $p);<br>
 * </code>
 * 
 * @category   LibreMVC
 * @package    Database
 * @subpackage Driver
 * @subpackage MySQL
 * @copyright  Copyright (c) 1793-2222 Inwebo Veritas (http://www.inwebo.net)
 * @license    http://framework.zend.com/license   BSD License
 * @version    $Id:$
 * @link       https://github.com/inwebo/Template
 * @since      File available since Beta
 * @author     Inwebo Veritas <inwebo@gmail.com>
 */
class MySQL extends Database {

    /**
     * Création d'un nouvel objet PDO. Les transactions se font en UTF-8 Par
     * default.
     * 
     * @param String $host
     * @param String $database
     * @param String $username
     * @param String $passwd
     * @param Array $options
     * @return \PDO
     */
    public function __construct($host, $database, $username, $passwd, $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")) {
        try {
            $dsn = 'mysql:host=' . $host . ';dbname=' . $database;
            $this->resource = new PDO($dsn, $username, $passwd, $options);
            return $this->resource;
        } catch (Exception $error_string) {
             echo $error_string->getMessage();
        }
    }
}