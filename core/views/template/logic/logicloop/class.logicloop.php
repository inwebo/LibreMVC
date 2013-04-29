<?php
namespace LibreMVC\Views\Template\Logic;

use LibreMVC\Views\Template as Template;
use LibreMVC\Views\Template\Logic as Logic;
use LibreMVC\Views\Template\Logic\LogicComparison as LogicComparison;
use LibreMVC\Views\Template\Logic\LogicConst as LogicConst;
use LibreMVC\Views\Template\Logic\LogicIf as LogicIf;
use LibreMVC\Views\Template\Logic\LogicInclude as LogicInclude;
use LibreMVC\Views\Template\Logic\LogicLoop as LogicLoop;
use LibreMVC\Views\Template\Logic\LogicNoparse as LogicNoparse;
use LibreMVC\Views\Template\Logic\LogicTpl as LogicTpl;
use LibreMVC\Views\Template\Logic\LogicVar as LogicVar;
use LibreMVC\Views\Template\Parser as Parser;
use LibreMVC\Views\Template\Tag as Tag;
use LibreMVC\Views\Template\Task as Task;
use LibreMVC\Views\Template\Task\TaskComparison as TaskComparison;
use LibreMVC\Views\Template\Task\TasksTag as TasksTag;
use LibreMVC\Views\Template\ViewBag as ViewBag;
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
 * @category   LibreMVC
 * @package    View
 * @subpackage Template
 * @subpackage Logic
 * @copyright Copyright (c) 2005-2012 Inwebo (http://www.inwebo.net)
 * @license   http://http://creativecommons.org/licenses/by-nc-sa/3.0/
 * @version   $Id:$
 * @link      https://inwebo@github.com/inwebo/My.Sessions.git
 * @since     File available since Beta 01-01-2012
 */

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
class LogicLoop extends \LibreMVC\Views\Template\Logic {

    /**
     * Boucle sur un tableau
     * 
     * @param array $match Un tableau de retour de preg_match_all
     * @return string Le contenu fichier template modifié par une fonction pcre
     */
    public function process($match) {
        $buffer = array();
        $this->match = $match;
        if (!isset(self::$ViewBag->$match[1])) {
            Parser::$trace[] = "Loop var $match[1] is not set";
            return null;
        }
        $logic = new \LibreMVC\Views\Template\Logic\LogicVar();
       
        foreach (self::$ViewBag->$match[1] as self::$ViewBag->key => self::$ViewBag->value) {
            $buffer[] = preg_replace_callback(PATTERN_VAR, array($logic, 'process'), $match[2]);
        }

        return implode('', $buffer);
    }

}