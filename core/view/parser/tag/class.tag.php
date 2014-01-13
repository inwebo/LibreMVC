<?php
namespace LibreMVC\View\Parser;
/**
 * Représentation d'un tag à parser.
 *
 * Objet simple avec un seul attribut pattern qui est un pattern PCRE.
 *
 * @category   LibreMVC
 * @package    View
 * @subpackage Template
 * @subpackage Tag
 * @copyright  Copyright (c) 1793-2222 Inwebo Veritas (http://www.inwebo.net)
 * @license    http://framework.zend.com/license   BSD License
 * @version    $Id:$
 * @link       https://github.com/inwebo/Template
 * @since      File available since Beta
 */
class Tag {

    /**
     * Echappement du parser
     */
    const ESCAPEMENT = '#\{noparse\}(.*)\{\/noparse\}#ismU';
    /**
     * Constante est en majuscule {CONSTANTE}.
     */
    const CONSTS    = '#\{([A-Z_]*)\}#';
    const VARS      = '#\{\$([aA-zZ_]*)\}#';

    /**
     * Boucle
     */
    const LOOP          = '#(\{loop *= *"\$.*\".*\}.*\{\/loop\})#ism';
    const LOOP_HEADER   = '#(\{loop="\$.*\".*\})#ismU';
    const LOOP_BODY     = '#\}(?!\})(.*)\{{1}\/{1}loop\}{1}#ism';
    const LOOP_AS       = '#([a-zA-Z_]*)=>([a-zA-Z_]*)#';
    const LOOP_ITERABLE = '#\{loop="\$(.*)\".*\}#ismU';
    const LOOP_BODY_VARS= '#(.*)\{loop *= *"\$.*\".*\}.*\{\/loop\}(.*)#ism';
    const INCLUDER      = '#\{inc=(.*)\}#';
    const TEMPLATE      = '#\{tpl=(.*)\}#';

    /**
     * Un pattern PCRE à rechercher dans le template.
     * @vars string
     */
    protected $pattern = "";

    /**
     * Setter pattern PCRE à rechercher dans le template.
     * 
     * @param string $pattern Un pattern PCRE à rechercher dans le template.
     */
    public function __construct($pattern) {
        $this->pattern = $pattern;
    }

    public function getPattern(){
        return $this->pattern;
    }

}