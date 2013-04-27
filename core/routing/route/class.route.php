<?php
/**
 * Created by JetBrains PhpStorm.
 * User: julien
 * Date: 22/04/13
 * Time: 13:10
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMCV\Routing;


class Route {
    /**
     * @var string route Partie dans l'uri obligatoire.
     */
    public $name ="";
    public $pattern;
    public $controller = "\\LibreMVC\\Core\\Controllers\\RootController";
    public $action = "index";
    public $params;

    /**
     * @todo contructeur doit avoir un parametre booleen isCustomClass
     * Si vrai chargenement depuis le nom de la class, pas par l'autoloader.
     */

    public function extractMandatorySegment() {
        $crochetStart = strpos($this->pattern,"[");
        if( $crochetStart !== false ) {
            $mandatory = substr( $this->pattern, 0, $crochetStart );
        }
        else {
            $mandatory = $this->pattern;
        }
        return $mandatory;
    }

    public function patternToArray( $withoutMandatory = false) {
        $named = preg_match_all(
            "#\[{1}(.*)\]{1}#mU",
            $this->pattern,
            $match
        );
        return ( $withoutMandatory === false ) ? array_merge($this->mandatoryToArray(),$match[0]) : $match[0] ;
    }

    public function mandatoryToArray() {
        $mandatory = $this->extractMandatorySegment();
        // 1 - Final slash ?
        $finalSlash = (substr($mandatory, -1) === '/') ? true : false ;

        $mandatoryAsArray = explode('/', trim($mandatory) );
        $buffer = array();
        foreach($mandatoryAsArray as $value){
            // Slash final
            if($value === '') {
                //$buffer[] = '/';
            }
            else {
                $buffer[] = '/';
                $buffer[] = $value;
            }

        }
        if( $finalSlash ) {
            $buffer[] = '/';
        }
        return $buffer;
    }

}