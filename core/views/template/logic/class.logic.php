<?php
namespace LibreMVC\Views\Template;
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
 * @copyright Copyright (c) 2005-2012 Inwebo (http://www.inwebo.net)
 * @license   http://http://creativecommons.org/licenses/by-nc-sa/3.0/
 * @version   $Id:$
 * @link      https://inwebo@github.com/inwebo/My.Sessions.git
 * @since     File available since Beta 01-01-2012
 */

/**
 * Class métier à appliqué sur un objet Tag.
 *
 * Objet métier, sera le function de callback de preg_match_all voir la class
 * Task
 *
 * @category   LibreMVC
 * @package    View
 * @subpackage Template
 * @copyright  Copyright (c) 1793-2222 Inwebo Veritas (http://www.inwebo.net)
 * @license    http://framework.zend.com/license   BSD License
 * @version    $Id:$
 * @link       https://github.com/inwebo/Template
 * @since      File available since Beta
 * @abstract
 */
abstract class Logic {

    /**
     * Une chaine correspondant à un pattern PCRE.
     * @var string
     */
    public $match;

    /**
     * Une chaine de caractère à afficher dans la sortie courante.
     * @var string
     */
    public $buffer = "";

    /**
     * Singleton d'un objet ViewBag
     * @static
     * @var string
     */
    protected static $ViewBag;

    /**
     * Setter viewbag.
     * @todo Injection de dépendance.
     */
    public function __construct() {
        self::$ViewBag = \LibreMVC\Views\Template\ViewBag::get();
    }

    /**
     * Signature du callback de preg_match_all.
     */
    public function process($match) {}

}
