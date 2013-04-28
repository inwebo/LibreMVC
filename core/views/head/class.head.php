<?php
namespace LibreMVC\Views;
use \Exception;
use LibreMVC\Database\Entity;
/**
 * Moteur de template rapide et léger.
 *
 *
 * LICENSE: Some license information
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

/**
 * Représentation d'un fichier template
 *
 * Un template est un fichier dans lequel se trouve le contenu à
 * Parser.
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

class Head extends Entity{

    public $title;
    public $md5;
    public $description;
    public $keywords;
    public $author;
    
    /**
     * Constructeur de l'objet
     */
    public function __construct() {}
    
    static public function getHeadByHash($md5) {
        //$tmp = \LibreMVC\Database\Driver::get('routes')->query('SELECT * FROM heads WHERE md5=?',array($md5));
        /*if( isset($tmp[0]) ) {
            return $tmp[0];
        } */       
    }
}
