<?php
/**
 * Created by JetBrains PhpStorm.
 * User: julien
 * Date: 22/04/13
 * Time: 13:10
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Routing;
use LibreMVC\Database\Entity;

class Route extends Entity{
    /**
     * @var string route Partie dans l'uri obligatoire.
     */
    public $name;
    public $pattern;
    public $controller;
    public $action;
    public $params;
    public $type = 'page';

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
            //@todo a revoir mange le crochet fermant
            //"#\[{1}(.*)\]{1}#mU",
            //@todo a tester
            "#(\[:(.*)(\#\])|\[{1}(.*)\|\#\]$]{1})|\[{1}(.*)\]{1}#mU",
            $this->pattern,
            $match
        );
        //var_dump($match);
        return ( $withoutMandatory === false ) ? array_merge( $this->mandatoryToArray(), $match[0] ) : $match[0] ;
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