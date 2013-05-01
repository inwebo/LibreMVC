<?php
namespace LibreMVC\Database\Driver;

use \PDO;
use LibreMVC\Database;
use \Exception;

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
 * @subpackage SQlite
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
 * Pour des raisons de sécurité il est conseillé de placer la base de donnée dans
 * un dossier différent du dossier courante.
 *
 * <code>
 * <br>
 * // Exemple avec une connexion SQlite<br>
 * $user = new lSQlite( 'db/db.sqlite3' );<br>
 * </code>
 *
 * @category   LibreMVC
 * @package    Database
 * @subpackage Driver
 * @subpackage SQlite
 * @copyright  Copyright (c) 1793-2222 Inwebo Veritas (http://www.inwebo.net)
 * @license    http://framework.zend.com/license   BSD License
 * @version    $Id:$
 * @link       https://github.com/inwebo/Template
 * @since      File available since Beta
 * @author     Inwebo Veritas <inwebo@gmail.com>
 */
class SQlite extends  Database\Driver{

    /**
     * @param $filename
     * @throws Exception
     */
    public function __construct( $filename ) {
        try {
            $this->resource = new PDO('sqlite:' . $filename);

            if( !is_file($filename) && !is_writable($filename) ) {
                throw new Exception('Database : ' . $filename . ' is not writable or not found.');
            }
            if( !is_writable( getcwd(). '/'. dirname($filename) ) ) {
                throw new Exception('Base folder : ' . getcwd() . '/' . dirname($filename) . ' is not writable.');
            }
            else {
                return $this->resource;
            }
        } catch (Exception $error_string) {
            echo $error_string->getMessage();
        }
    }


}