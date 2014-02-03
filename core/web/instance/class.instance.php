<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 02/02/14
 * Time: 23:19
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Web;

use LibreMVC\Http\Context;
const DEFAULT_INSTANCE = "_default";
const DEFAULT_BASE_DIR = "sites/";

class Instance {
    /**
     * @var Url courante
     */
    protected $_url;
    /**
     * @var L'url d'entrée dans l'instance courante.
     */
    protected $_baseUrl;
    /**
     * @var Le dossier contenant toutes les instances
     */
    protected $_baseDir;
    /**
     * @var Le nom du dossier de l'instance courante.
     */
    protected $_dir;
    /**
     * @var Le realpath de l'instance courante.
     */
    protected $_realPath;
    /**
     * @var Convertit le chemin disque en url valide.
     */
    protected $_includeUrl;
    /**
     * @var L'URI courante de l'instance courante
     */
    protected $_uri;
    /**
     * @var Les segments de l'URI à ignorer l'instance courante est un sous dossier d'une autre instance.
     */
    protected $_baseUri;

    public function __construct( $url, $baseDir = null ) {
        $this->_url = $url;
        $this->_baseUrl = $this->getBaseUrl();
        $this->_baseDir = ( is_null( $baseDir ) ? DEFAULT_BASE_DIR : $baseDir );
        $this->_dir = $this->findCurrentDir();
        $this->_realPath = $this->getRealPath();
        $this->_includeUrl = $this->_baseUrl . $this->_baseDir . $this->_dir . '/';
        $this->_baseUri = $this->getBaseUri();
        $this->_uri = $this->getUri();
    }

    public function getUri() {
        // Url sans la query string
        $_url = $this->urlToInstanceSyntax( strtok($this->_url,'?') );
        $_baseUri = ltrim(str_replace('/','.',$this->_baseUri),'.');
        if( $this->_dir !==  DEFAULT_INSTANCE) {
            // Instance syntax dir
            // To array
            $getUri = explode($_baseUri, $_url);
            // Ne garde que ce qui se trouve à droite de l'url
            array_shift($getUri);
            // To uri
            $getUri = str_replace( '.','/',ltrim($getUri[0],'.') ) . '/';
            return $getUri;
        }
        else {
            $getUri = explode($_baseUri, $_url);
            if( isset($getUri[1]) ) {
                $getUri = str_replace('.','/',$getUri[1]) . "/";
            }
            else {
                $getUri = "/";
            }

            return $getUri;
        }
    }

    static public function uriToArray( $uri ) {
        return explode('/',trim( $uri,'/'));
    }

    /**
     * Dossier courant du script d'execution.
     * @return string
     */
    public function getBaseUri() {
        if( $this->_dir !==  DEFAULT_INSTANCE) {
            $server = $this->urlToInstanceSyntax(Context::getServer());
            $serverArray = explode('.', $server);
            $currentDir = explode('.', $this->_dir);
            return implode('/',array_diff($currentDir,$serverArray))."/";
        }
        else {
            $pathInfo = pathinfo( $_SERVER['PHP_SELF'] );
            return ltrim($pathInfo['dirname'],'/')."/";
        }
    }

    /**
     * L'url de base du context courant.
     * @return string
     */
    public function getBaseUrl() {
        $pathInfo = pathinfo( $_SERVER['PHP_SELF'] );
        $hostName = $_SERVER['HTTP_HOST'];
        $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https://'?'https://':'http://';
        $string = $protocol.$hostName.$pathInfo['dirname'];
        $string .= ( $string[strlen($string)-1] === '/'  ) ? '' : '/';
        return $string;
    }

    /**
     * Le real path de l'instance courante.
     * @return string
     */
    public function getRealPath() {
        return realpath($this->_baseDir . $this->_dir . "/");
    }

    /**
     * Analyse l'url de droite à gauche puis de gauche à droite.
     *
     * @return string
     */
    public function findCurrentDir() {
        $url  = $url2 = explode('.', self::urlToInstanceSyntax( $this->_url ) );
        $loop = count($url);
        $name = null;
        for($i=1; $i <= $loop; $i++) {
            $asDirName =   implode('.', $url);
            if(is_dir( getcwd() . "/" .$this->_baseDir . $asDirName . "/")) {
                return implode('.', $url);
            }
            array_pop($url);
        }

        $name = null;
        for($i=1; $i <= $loop; $i++) {
            $asDirName =   implode('.', $url2);
            if(is_dir( getcwd() . "/" .$this->_baseDir . $asDirName . "/")) {
                return implode('.', $url2);
            }
            array_shift($url2);
        }


        return DEFAULT_INSTANCE;
    }

    /**
     * Retourne une url avec la syntaxe des instances attendues dans le DEFAULT_BASE_DIR
     *
     * http://www.inwebo.dev/www.inwebo.dev.mvc.admin/ ->www.inwebo.dev.www.inwebo.dev.mvc.admin
     *
     * @param $url
     * @return string
     */
    static public function urlToInstanceSyntax($url) {
        $url = parse_url($url) ;
        array_shift($url);
        return strtolower(trim(str_ireplace('/', '.', implode('',$url)), '.'));
    }

}