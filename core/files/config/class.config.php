<?php

namespace LibreMVC\Files;
class ConfigFileException extends \Exception {}

/**

 */

/**
 * Class Config
 *
 * Parse le fichier config.ini et renvoie les clefs / valeurs. Is a Multiton.
 *
 * @package LibreMVC\Files
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

    private function __construct( $file, $process_sections = true)
    {
        if( array_key_exists($file, self::$_instances) ) {
            return self::$_instances[$file];
        }

        if ( ( $config = @parse_ini_file( $file, $process_sections ) ) == false ) {
            throw new ConfigFileException('Config file ' . $file . ' not found.');
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
        $temp = new \StdClass();
        foreach ($inputArray as $key => $value) {
            $temp->$key = (object)$value;
        }
        return (object)$temp;
    }

    public static function load($file, $process_section = true, $alias = null)
    {
        if (!array_key_exists($file, self::$_instances)) {
            self::$_instances[$file] = new self($file, $process_section);
        }
        return self::$_instances[$file]->keys;
    }

}