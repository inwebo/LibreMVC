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
     * @var array Contient les instances de fichier de configuration
     */
    private static $_instances = array();

    /**
     * @var object Toutes les clefs valeurs du fichier ini
     */
    private $keys;

    /**
     * @var string Chemin du fichier de configuration
     */
    private $file;

    private function __construct($file, $process_sections = true)
    {
        if (($config = @parse_ini_file($file, $process_sections)) == false) {
            throw new Exception('Config file ' . $file . ' not found.');
        } else {
            $this->file = $file;
            $this->keys = (object)$config;
            if ($process_sections) {
                $this->keys = self::arrayToObject($this->keys);
            }
            return $this->keys;
        }
    }

    private static function arrayToObject($inputArray)
    {
        $temp = new StdClass();
        foreach ($inputArray as $key => $value) {
            $temp->$key = (object)$value;
        }
        return (object)$temp;
    }

    public static function load($file, $process_section = true)
    {
        if (!array_key_exists($file, self::$_instances)) {
            self::$_instances[$file] = new Config($file, $process_section);
        }
        return self::$_instances[$file]->keys;
    }

}
