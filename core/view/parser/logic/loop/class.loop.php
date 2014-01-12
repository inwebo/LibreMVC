<?php
namespace LibreMVC\View\Parser\Logic;

/**
 * Class métier à appliqué sur un Tag Loop.
 *
 * Objet métier, sera le function de callback de preg_match_all cf la class Task
 * Itére un tableau.
 * 
 * <code>
 * <ul>
 * {loop array="{$array}"}
 * <li>{$key},{$value}</li>
 * {/loop}
 * </ul>
 * </code>
 *
 * @category   LibreMVC
 * @package    View
 * @subpackage Template
 * @copyright  Copyright (c) 1793-2222 Inwebo Veritas (http://www.inwebo.net)
 * @license    http://framework.zend.com/license   BSD License
 * @version    $Id:$
 * @link       https://github.com/inwebo/Template
 * @since      File available since Beta
 */
use LibreMVC\View\Parser\Logic;

class Loop extends Logic {

    /**
     * Boucle sur un tableau
     * 
     * @param array $match Un tableau de retour de preg_match_all
     * @return string Le contenu fichier template modifié par une fonction pcre
     */
    public function process($match) {
        $buffer = array();
        if (!isset(self::$ViewBag->$match[1])) {
            // Error
            return null;
        }
        $logic = new LogicVar();
       
        foreach (self::$ViewBag->$match[1] as self::$ViewBag->key => self::$ViewBag->value) {
            $buffer[] = preg_replace_callback(PATTERN_VAR, array($logic, 'process'), $match[2]);
        }

        return implode('', $buffer);
    }

}