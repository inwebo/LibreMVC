<?php
namespace LibreMVC\Views\Template\Logic;

use LibreMVC\Views\Template\Parser;
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
 * Class métier à appliqué sur un Tag de variable.
 *
 * Objet métier, sera le function de callback de preg_match_all voir la class
 * Task
 * <code>
 * {@vars}
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
use LibreMVC\Views\Template\Task;
use LibreMVC\Views\Template\ViewBag;

class LogicVar extends Logic {

    /**
     * Setter match. Applique une class métier sur un pattern PCRE.
     * 
     * @param array $match Un tableau de retour de preg_match_all
     * @return string Le contenu fichier template modifié par une fonction pcre
     */
    public function process($match) {
        $this->match = $match;
        ob_start();
        if ( isset( self::$ViewBag->$match[1] ) ) {
            echo( self::$ViewBag->$match[1] );
        } else {
            Parser::$trace[] = "ViewBag vars ViewBag::$match[1] is not set";
            return null;
        }
        $this->buffer = ob_get_contents();
        ob_end_clean();
        return $this->buffer;
    }

    /**
     * Getter du nom de la variable php en cours.
     * 
     * @param array $match Un tableau de retour de preg_match_all
     * @return string Le nom de l'attribut de ViewBag
     */
    public function getMemberName($match) {
        return $match[1];
    }

    /**
     * Getter ViewBag.
     * 
     * @param array $match Un tableau de retour de preg_match_all
     * @return mixed La valeur de la variable en cours contenu dans le ViewBag
     */
    public function __get($match) {
        //@todo child node
        Parser::$trace[] = $match[1];
        return self::$ViewBag->$match[1];
    }

}