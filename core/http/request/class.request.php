<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 02/05/13
 * Time: 22:32
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMCV\Http;

use LibreMVC\Http\Context;

/**
 * Class Request
 * @package LibreMCV\Http
 */
class Request {

    /**
     * @var bool URL stricte
     * @see RFC-
     */
    public $paranoid = true;

    /**
     * @var Request Instance courante
     */
    static protected $instance;

    /**
     * @var string Url brute courante
     */
    protected $rawUrl;

    /**
     * @var string Url sanitized
     */
    public $url;

    /**
     * @var string Uri brute courante
     */
    protected $rawUri;

    /**
     * @var Uri sanitized
     */
    public $uri;

    /**
     * @var string Verbe de l'en tête HTTP
     */
    public $verb;

    /**
     * @param null|string $rawUrl
     * @param null|string $rawUri
     */
    private function __construct( $rawUrl = null, $rawUri = null) {
        $this->rawUrl = ( !is_null( $rawUrl ) ) ? $rawUrl : Context::getUrl( false );
        $this->url = ( $this->paranoid ) ? $this->paranoid( $this->rawUrl ) : $this->rawUrl ;
        $this->rawUri = ( !is_null( $rawUri ) ) ? $rawUri : $_SERVER['REQUEST_URI'];
        $this->uri =  ( $this->paranoid ) ? $this->paranoid( $this->rawUri ) : $this->rawUri ;
        $this->verb = Context::getHttpVerb();
    }

    /**
     * Singleton pattern
     */
    private function __clone(){}

    /**
     * @param null $rawUrl
     * @param null $rawUri
     * @return Request
     */
    static public function current ( $rawUrl = null, $rawUri = null ) {
        if( is_null( self::$instance ) ) {
            self::$instance = new self($rawUrl,$rawUri);
            return self::$instance;
        }
        return self::$instance;
    }

    /**
     * @param bool $activate
     */
    public function setParanoid( $activate = true ) {
        $this->paranoid = ( is_bool( $activate ) && $activate ) ? $activate : false;
    }

    /**
     * Sanitize uri
     *
     * Utilise filter_var pour encoder tous les caracteres malveillants.
     * Produit un encodage uri, tous les valeu d'echappement seront supprimés
     * Tous les slash inutiles seront supprimés
     *
     * @param string $urlOrUri La chaine à nettoyée
     * @param bool $queryString Doit ont inclure la query string càd apres le ?
     * @return mixed|string la chaine nettoyée
     */
    protected function paranoid( $urlOrUri, $queryString = false ) {
        // Sanitize
        $urlOrUri = filter_var($urlOrUri, FILTER_SANITIZE_URL);
        // Multiple /
        $urlOrUri = preg_replace("#/+#",'/',$urlOrUri);
        // With query string ?
        if( $queryString === false && isset( $_SERVER['QUERY_STRING'] ) ) {
            $urlOrUri = str_replace("?".$_SERVER['QUERY_STRING'],'', $urlOrUri);
        }
        // Delete encoded uri char
        $urlOrUri = preg_replace("#%[0-9-a-e-A-E]{2}#",'',$urlOrUri);

        return ( $urlOrUri === "" ) ? "/" : $urlOrUri ;
    }

    /**
     * @param bool $uri
     * @param bool $object
     * @return array|object
     */
    public function toArray( $uri = false, $object = false ) {
        $url = ( $uri )  ? $this->uri : $this->url;
        $raw = explode( '/', $url );
        if( $raw[0] === '' ) {
            unset($raw[0]);
        }

        $buffer = array();

        foreach($raw as $key => $value){
            // Slash final
            if( $value === '') {
                $buffer[] = '/';

            }
            else {
                $buffer[] = '/';
                $buffer[] = $value;
            }

        }
        // Si c'est l url demandee le premier slash est null
        if( $uri === false ) {
            array_shift($buffer);
        }
        return ( $object !== false ) ? (object) $buffer : $buffer;
    }


}