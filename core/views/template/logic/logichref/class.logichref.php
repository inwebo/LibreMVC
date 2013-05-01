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
 * Class métier à appliqué sur un Tag constante.
 *
 * Objet métier, sera le function de callback de preg_match_all cf la class Task.
 * Affiche la valeur d'une constante.
 * <code>
 * {THIS_IS_CONSTANTE}
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

class LogicHref extends \LibreMVC\Views\Template\Logic {

    /**
     * Setter match. Applique une class métier sur un pattern PCRE.
     * 
     * @param array $match Un tableau de retour de preg_match_all
     * @return string Le contenu fichier template modifié par une fonction pcre
     */
    public function process( $match ) {

        $this->match = $match;

        ob_start();
        if (defined($match[1])) {
            echo 'http://www.google.fr' . $match[1];
        }
        else {
            \LibreMVC\Views\Template\Parser::$trace[] = "Constante $match[1] is not set";
            echo 'http://www.google.fr';
        }
        $this->buffer = ob_get_contents();
        ob_end_clean();
        return $this->buffer;
    }

}
