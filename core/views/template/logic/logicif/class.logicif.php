<?php
namespace LibreMVC\Views\Template\Logic;

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
 * Class métier à appliqué sur un Tag if.
 * 
 * <code>
 * {if "{$isTrue}==={$isTrue}"}
 * echo 'vrai';
 * {else}
 * echo 'faux';
 * {fi}
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

use LibreMVC\Views\Template;
use LibreMVC\Views\Template\Logic;
use LibreMVC\Views\Template\Logic\LogicComparison;
use LibreMVC\Views\Template\Logic\LogicLoop;
use LibreMVC\Views\Template\Logic\LogicVar;
use LibreMVC\Views\Template\Parser;
use LibreMVC\Views\Template\Task;
use LibreMVC\Views\Template\ViewBag;

class LogicIf extends Logic {

    /**
     * Applique une classe métier LogicComparison au Tag if
     * 
     * @param array $match Un tableau de retour de preg_match_all
     * @return string Le contenu fichier template modifié par une fonction pcre
     */
    public function process($match) {
        $this->match = $match;
        $comparison = new LogicComparison();
        $assert = $comparison->process($match[1]);
        ( $assert ) ? $this->buffer .= $match[2] : $this->buffer .= $match[3];
        return $this->buffer;
    }

}