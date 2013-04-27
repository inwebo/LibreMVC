<?php

namespace LibreMVC\Files\IO;

/**
 * Aide pour l'ecriture de fichier.
 *
 * @category   LibreMVC
 * @package    Files
 * @subpackage IO
 * @copyright  Copyright (c) 1793-2222 Inwebo Veritas (http://www.inwebo.net)
 * @license    http://framework.zend.com/license   BSD License
 * @version    $Id:$
 * @link       https://github.com/inwebo/Template
 * @since      File available since Beta
 */
class Write {

    /**
     * Ecrit dans $filename le contenu de $content.
     *
     * @param type $filename
     * @param type $content
     * @return boolean False si le fichier n'est pas writable sinon True
     */
    public static function content($filename, $content) {
        if (!is_writable($filename)) {
            trigger_error("Cannot write into $filename", E_USER_NOTICE);
            return false;
        } else {
            $handle = fopen($filename, 'w+');
            fwrite($handle, $content);
            fclose($handle);
            return true;
        }
    }

}
