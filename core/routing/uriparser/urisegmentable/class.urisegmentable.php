<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 05/01/14
 * Time: 12:25
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Routing\UriParser;

class UriSegmentable implements Segmentable{

    protected $raw;
    public $value;

    public function __construct( $uri ) {
        $this->raw = $uri;
        $this->value = $this->sanitize( $this->raw );
    }

    static function current() {
        return new self($_SERVER['REQUEST_URI']);
    }

    /**
     * Sanitize url
     *
     * Utilise filter_var pour encoder tous les caracteres malveillants.
     * Produit un encodage uri, toutes les valeurs d'echappement seront supprimés
     * Tous les slash inutiles seront supprimés
     *
     * @param string $uri La chaine à nettoyée
     * @param bool $queryString Doit ont inclure la query string chaine apres ?
     * @return mixed|string la chaine nettoyée
     */
    protected function sanitize( $uri, $queryString = false ) {
        // Sanitize
        $uri = filter_var($uri, FILTER_SANITIZE_URL);
        // Multiple /
        $uri = preg_replace("#/+#",'/',$uri);
        // With query string ?
        if($queryString === false && isset($_SERVER['QUERY_STRING']) ) {
            $uri = str_replace("?".$_SERVER['QUERY_STRING'],'', $uri);
        }
        // Delete encoded uri char
        $uri = preg_replace("#%[0-9-a-e-A-E]{2}#",'',$uri);

        return ( $uri === "" ) ? "/" : $uri ;
    }

    public function toArray( $object = false ) {
        $raw = explode('/',$this->value);
        if( $raw[0] === '' ) {
            unset($raw[0]);
        }

        $buffer = array();

        foreach($raw as $key => $value){
            // Slash final
            if($value === '') {
                $buffer[] = '/';

            }
            else {
                $buffer[] = '/';
                $buffer[] = $value;
            }

        }
        return ( $object !== false ) ? (object) $buffer : $buffer;
    }

    /**
     * @todo
     */
    public function toSegments() {

    }

}