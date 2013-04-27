<?php

namespace LibreMVC\Files;
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
     * @category  LibreMVC
     * @package   Files
     * @subpackage config
     * @copyright Copyright (c) 2005-2012 Inwebo (http://www.inwebo.net)
     * @license   http://http://creativecommons.org/licenses/by-nc-sa/3.0/
     * @version   $Id:$
     * @link      https://inwebo@github.com/inwebo/My.Sessions.git
     * @since     File available since Beta 01-01-2012
     */

/**
 * Parse le fichier config.ini et renvoie les clefs / valeurs.
 *
 * @category   LibreMVC
 * @package    Files
 * @subpackage Config
 * @copyright  Copyright (c) 1793-2222 Inwebo Veritas (http://www.inwebo.net)
 * @license    http://framework.zend.com/license   BSD License
 * @version    $Id:$
 * @link       https://github.com/inwebo/Template
 * @since      File available since Beta
 */

class Config
{
    /**
     * Contient l'instance courante.
     *
     * @var object
     */
    static $get;

    /**
     * Chemin d'accés au fichier à parser.
     *
     * @var string
     */
    static $path;

    /**
     * Constructeur privé. Est donc un singleton
     */
    private function __construct(){}

    /**
     * @param $configFile
     * @param bool $process_sections
     * @return object
     * @throws Exception
     */
    public static function get($configFile, $process_sections = FALSE)
    {
        if ((self::$get = (object)parse_ini_file($configFile, $process_sections)) === false) {
            throw new Exception('File not found.');
        } else {
            self::$path = $configFile;
        }
        return self::$get;
    }

    /**
     * Corrige l'indentation dans un fichier ini.
     *
     * Permet d'avoir le contenu d'un fichier ini correctement formaté.
     *
     * @param type $ini_file Chemin d'accés fichier ini
     * @return String Contenu du fichier ini formaté
     * @throws Exception si le fichier n'est pas
     */
    private static function format($ini_file)
    {
        $return = '';
        if (is_array($ini_file)) {
            $format = $ini_file;
        } elseif (is_file($ini_file)) {
            $format = self::get($ini_file, TRUE);
        } else {
            throw new Exception('Can\'t open ini file ' . $ini_file);
        }

        foreach ($format as $key => $value) {

            if (is_array($value)) {
                $return .= '[' . $key . ']' . "\n";
                $maxChar = 0;
                foreach ($value as $_key => $_value) {
                    (strlen($_key) > $maxChar) ? $maxChar = strlen($_key) + 1 : NULL;
                }

                foreach ($value as $_key => $_value) {
                    ob_start();
                    $return .= sprintf("%-" . $maxChar . "s", $_key);
                    $return .= '=';
                    $return .= ' "' . $_value . '"' . "\n";
                    ob_end_flush();
                }
            } else {
                $return .= $key . '=' . ' "' . $_value . '"' . "\n";
            }
        }

        return $return;
    }

    /**
     * Setter
     *
     * @param String $name
     * @param String $value
     */
    public function __set($name, $value)
    {
        $this->get(self::$path)->$name = $value;
    }

}
