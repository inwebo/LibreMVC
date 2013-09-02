<?php

namespace LibreMVC;



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
 * @subpackage Instance
 * @copyright Copyright (c) 2005-2012 Inwebo (http://www.inwebo.net)
 * @license   http://http://creativecommons.org/licenses/by-nc-sa/3.0/
 * @version   $Id:$
 * @link      https://inwebo@github.com/inwebo/My.Sessions.git
 * @since     File available since Beta 01-01-2012
 */

/**
 * Détermine le dossier de travail courant selon une url.
 * 
 * Simple extension de la class PHP PDO
 * @category   LibreMVC
 * @package    Http
 * @subpackage Route
 * @copyright  Copyright (c) 1793-2222 Inwebo Veritas (http://www.inwebo.net)
 * @license    http://framework.zend.com/license   BSD License
 * @version    $Id:$
 * @link       https://github.com/inwebo/Template
 * @since      File available since Beta
 */

use LibreMVC\Files\Config;
use LibreMVC\Http\Context;

class Instance {

    protected  $default = "_default";
    public $baseUrl;
    protected $baseDir;
    public $name;
    public $url;
    public $realPath;
    public $includeUrl;
    /**
     * ajouter mandatory asserts
     */
    /**
     * @var string Segment non obligatoire dans l'uri
     */
    public $uri;

    /**
     * @var Devrait etre le dossier courant d'execution
     */
    public $baseUri;


    public function __construct( $url, $baseDir = "sites/" ) {
        $this->url = $url;
        $this->baseDir = $baseDir;
        $this->name = $this->getName();
        // @todo n'est pas les realpath racine de l'application
        $this->realPath = Context::getBaseDirRealPath( getcwd() ) . $this->baseDir . $this->name . "/";
        $this->baseUrl = Context::getBaseUrl();
        $this->includeUrl = Context::getBaseUrl().$this->baseDir . $this->name . "/";
        $this->uri = Context::getInstanceUri($this->name);
        $this->baseUri = Context::getBaseUri();
    }

    static public function current( $baseDir = "sites/" ) {
        return new self( Context::getUrl(), $baseDir );
    }

    public function getRootDir() {

    }

    public function getName() {
        $url = explode('.', self::toDirName( $this->url ) );
        $loop = count($url);
        $name = null;
        for($i=1; $i <= $loop; $i++) {
            $asDirName =   implode('.', $url);
            if(is_dir( getcwd() . "/" .$this->baseDir . $asDirName . "/")) {
                return implode('.', $url);
            }
            array_pop($url);
        }
        return $this->default;
    }

    static public function toDirName($url) {
        $url = parse_url($url) ;
        array_shift($url);
        return strtolower(trim(str_ireplace('/', '.', implode('',$url)), '.'));
    }

    public function processPattern( $config, $controller, $action ) {
        $processed = array();

        $patternArray = array_merge((array)$config->Dirs, (array)$config->Files, (array)$config->MVC, array("%instance%" => $this->name . '/', '%controller%' => $controller, "%action%" => $action));
        $stringsToProcess = array_merge((array)$config->InstancesPattern, (array)$config->GlobalPattern);

        foreach($stringsToProcess as $k => $v) {
            $processed[$k] = $this->processCallBack($v,$patternArray);
        }

        return (object)$processed;
    }

    public function processBaseIncludePattern( $baseUrl, $paths ) {
        $processed = array();
        foreach($paths as $k => $v) {
            $processed[$k] = $baseUrl . $v;
        }
        return (object)$processed;
    }

    /**
     * @param array $stringToProcess
     * @param array $patterns
     * @return mixed
     */
    protected function processCallBack( $stringToProcess, $patterns ) {
        $treePool = $patterns;
        $search = array_keys($treePool);
        $replace = array_values($treePool);
        return str_replace($search, $replace, $stringToProcess);

    }

}