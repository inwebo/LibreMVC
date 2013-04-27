<?php
namespace LibreMVC\Views\Template;
/**
 * Une tâche est la combinaison d'un tag PCRE et d'une logique à lui appliquer.
 * 
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
Class Task {

    /**
     * Objet tag
     * @var Tag
     */
    public $tags;

    /**
     * Objet logic
     * @var Logic
     */
    public $logic;

    /**
     * Applique une classe métier LogicComparison au Tag if
     * 
     * Retourne le resultat de la comparaison de deux variables selon un opérateur.
     * 
     * @param object $tags Un objet tag
     * @param object $logic Un objet logic
     * @return string Le contenu fichier template modifié par une fonction pcre
     */
    public function __construct(Tag $tags, Logic $logic) {
        $this->tags = $tags;
        $this->logic = $logic;
    }

}
