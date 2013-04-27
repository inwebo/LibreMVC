<?php

namespace LibreMVC\Http;

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
 * @package   Http
 * @subpackage Route
 * @copyright Copyright (c) 2005-2012 Inwebo (http://www.inwebo.net)
 * @license   http://http://creativecommons.org/licenses/by-nc-sa/3.0/
 * @version   $Id:$
 * @link      https://inwebo@github.com/inwebo/My.Sessions.git
 * @since     File available since Beta 01-01-2012
 */

/**
 * Routes de l'application.
 * 
 * Simple extension de la class PHP PDO
 * @category   LibreMVC
 * @package    Http
 * @subpackage Route
 * @subpackage Template
 * @copyright  Copyright (c) 1793-2222 Inwebo Veritas (http://www.inwebo.net)
 * @license    http://framework.zend.com/license   BSD License
 * @version    $Id:$
 * @link       https://github.com/inwebo/Template
 * @since      File available since Beta
 */
class Context {

    /**
     * Url courante
     *
     * @return String
     */
    static public function getUrl() {
        $pageURL = 'http';
        $pageURL .= (isset($_SERVER["HTTPS"])) ? 's' : '';
        $pageURL .= "://" . $_SERVER["SERVER_NAME"];
        $pageURL .= ($_SERVER["SERVER_PORT"] != "80") ? ":" . $_SERVER["SERVER_PORT"] : '' ;
        $pageURL .= $_SERVER["REQUEST_URI"];
        return $pageURL;
    }

    /**
     * Retourne le realPath de l'application courante.
     *
     * @param bool $trailingSlash Ajout d'un slash final ?
     * @return string Un chemin absolue du système de fichier de l'hôte de l'application courante
     */
    static public function getBaseDirRealPath( $trailingSlash = true ) {
        $rp = realpath( __DIR__ );
        $rp.= ($trailingSlash) ? '/' : '';
        return $rp;
    }

    /**
     * Nom du dossier courant.
     *
     * @param bool $trailingSlash Ajout d'un slash final ?
     * @return string Nom du fichier courant.
     */
    static public function getBaseDir( $trailingSlash = true ) {
        $bd = basename(dirname(__FILE__));
        $bd.= ($trailingSlash) ? '/' : '';
        return $bd;
    }

    /**
     * Retourne l'url de base du repertoire courant.
     * @return string L'adresse courante.
     */
    static public function getBaseUrl() {
        $pathInfo = pathinfo($_SERVER['PHP_SELF']);
        $hostName = $_SERVER['HTTP_HOST'];
        $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https://'?'https://':'http://';
        return $protocol.$hostName.$pathInfo['dirname']."/";
    }

    /**
     * Retourne l'uri relative à l'instance courante.
     * @return mixed
     */
    static public function getUri() {
        return  str_replace( self::getBaseUrl(), '', self::getUrl() );
    }

    /**
     *
     */
    static public function getInstanceUri($name) {
        $arrayName = explode('.', $name);
        $arrayUri = explode('/', self::getUri());
        $url = array_diff($arrayUri,$arrayName);
        return trim(implode('/',$url), '/'). '/';

    }
}
