<?php
namespace LibreMVC\Helpers;
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
 * @package    Helpers
 * @copyright Copyright (c) 2005-2012 Inwebo (http://www.inwebo.net)
 * @license   http://http://creativecommons.org/licenses/by-nc-sa/3.0/
 * @version   $Id:$
 * @link      https://inwebo@github.com/inwebo/My.Sessions.git
 * @since     File available since Beta 01-01-2012
 */

/**
 * Classe de cryptage réversible de données
 *
 * Cette classe permet de coder ou décoder une chaine
 * de caractères
 *
 * @author CrazyCat <crazycat@c-p-f.org>
 * @copyright 2007 http://www.g33k-zone.org
 * @package Mephisto
 */

class Crypt {

    /**
     * Clé utilisée pour générer le cryptage
     * @var string
     */
    public $key;

    /**
     * Données à crypter
     * @var string
     */
    public $data;

    /**
     * Constructeur de l'objet
     * @param string $key Clé utilisée pour générer l'encodage
     */
    public function __construct($key) {
        $this->key = sha1($key);
    }

    /**
     * Encodeur de chaine
     * @param string $string Chaine à coder
     * @return string Chaine codée
     */
    public function code($string) {
        $this->data = '';
        for ($i = 0; $i < strlen($string); $i++) {
            $kc = substr($this->key, ($i % strlen($this->key)) - 1, 1);
            $this->data .= chr(ord($string{$i}) + ord($kc));
        }
        $this->data = base64_encode($this->data);
        return $this->data;
    }

    /**
     * Décodeur de Chaine
     * @param string $string Chaine à décoder
     * @return string
     */
    public function decode($string) {
        $this->data = '';
        $string = base64_decode($string);
        for ($i = 0; $i < strlen($string); $i++) {
            $kc = substr($this->key, ($i % strlen($this->key)) - 1, 1);
            $this->data .= chr(ord($string{$i}) - ord($kc));
        }
        return $this->data;
    }

}
