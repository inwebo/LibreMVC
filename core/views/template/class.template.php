<?php
namespace LibreMVC\Views;
use \Exception;
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
class Template {

    /**
     * Chemin d'accès au fichier à parser.
     * @var string
     */
    public $file;

    /**
     * La représentation sous forme d'une chaine du contenu du fichier.
     * @var string
     */
    public $content;

    /**
     * Constructeur de l'objet
     * 
     * Place le contenu du fichier dans l'attribut $content
     * 
     * @param string $file Chemin d'accès à un fichier.
     * @throws exception Si le fichier n'existe pas
     * @throws exception Si le fichier n'est pas lisable
     */
    public function __construct($file) {

        $this->file = $file;
        if (!file_exists($this->file)) {
            throw new Exception("Template $this->file does not exist.");
        } elseif (!is_readable($this->file)) {
            throw new Exception("Template $this->file is not readable.");
        } else {
            $this->read();
        }
    }

    /**
     * Lit le contenu du fichier et le place dans l'attribut content
     * 
     * Démarre la temporisation de sortie du buffer, inclus le fichier, récupère
     * et place dans content le contenu du buffer
     * 
     * @return void
     */
    private function read() {
        ob_start();
        include($this->file);
        $this->content = ob_get_contents();
        ob_end_clean();
    }

}
