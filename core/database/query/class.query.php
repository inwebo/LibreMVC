<?php

namespace LibreMVC\Database;

use \LibreMVC\Database\Driver;
use \LibreMVC\Database;

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
 * @subpackage Entity
 * @copyright Copyright (c) 2005-2012 Inwebo (http://www.inwebo.net)
 * @license   http://http://creativecommons.org/licenses/by-nc-sa/3.0/
 * @version   $Id:$
 * @link      https://inwebo@github.com/inwebo/My.Sessions.git
 * @since     File available since Beta 01-01-2012
 */

/**
 * La classe entité est la représentation logique d'une table probenant d'une
 * base de donnée quelconque.
 *
 * Tous les models souhaitant implémenter le design patter ORM DOIT étendre cette
 * classe de base.
 *
 * @category   LibreMVC
 * @package    Database
 * @subpackage Entity
 * @copyright  Copyright (c) 1793-2222 Inwebo Veritas (http://www.inwebo.net)
 * @license    http://framework.zend.com/license   BSD License
 * @version    $Id:$
 * @link       https://github.com/inwebo/Template
 * @since      File available since Beta
 * @author     Inwebo Veritas <inwebo@gmail.com>
 */
class Query {

    public function __construct() {
        
    }

    /**
     * Formate une clef
     * <code><br>
     * $key = Query::toKey("key");<br>
     * echo $key;<br>
     * //Retourne<br>
     * // `key`<br>
     * </code>
     * @param String $var la clef à formatée
     * @return String Chaine formatée
     */
    public static function toKey(&$value, $key) {
        $value = '`' . trim($value, '`') . '`';
    }

    /**
     * Formate une valeur.
     * @param String $value
     * @return String valeur formatée
     */
    public static function toValue(&$value, $key) {
        $value = "'" . $value . "'";
    }

    /**
     * Formate les couples attributPublic = valeur
     * `attributPublic` = 'valeur'
     * @param type $publicAttributs
     * @return boolean|string
     */
    public static function toCouple($publicAttributs) {
        if (empty($publicAttributs) || !is_array($publicAttributs)) {
            trigger_error("You must populate youre object before using it.");
            return false;
        }

        $buffer = "";
        $total = count($publicAttributs);
        $j=1;
        foreach ($publicAttributs as $key => $value) {
            $buffer .= ' `' . $key . '`="' . $value . "\" ";
            $buffer .= ( $total > 1 && $j < $total ) ? ', ' : '';
            ++$j;
        }
        return $buffer;
    }

    /**
     * Formate un tableau en chaine SQL valide pour les requêtes de type UPDATE
     *
     * @param array $publicAttributs Attributs public
     * @param string $wich both | cols | values
     * @return string Chaine formatée
     */
    public static function toList($publicAttributs, $wich = 'both') {
        if (!is_array($publicAttributs)) {
            trigger_error('Wrong parameter (' . gettype($publicAttributs) . ') $publicAttributs, must be Array.');
            return false;
        } else {
            $list = array();
            $list['cols'] = ' ( ' . implode(', ', $publicAttributs['cols']) . ' ) ';
            $list['values'] = ' ( ' . implode(', ', $publicAttributs['valuess']) . ' ) ';

            switch ($wich) {
                default:
                case 'both':
                    return $list;
                    break;

                case 'cols':
                    return $list['cols'];
                    break;

                case 'values':
                    return $list['values'];
                    break;
            }
        }
    }

}