<?php
namespace LibreMVC\View\Task;
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