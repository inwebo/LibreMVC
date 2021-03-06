<?php
/**
 * Created by JetBrains PhpStorm.
 * User: julien
 * Date: 22/04/13
 * Time: 13:10
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Routing;

use LibreMVC\Routing\UriParser\Segment;

/**
 * Class Route
 *
 * Une route represente un pattern valide d'une URI.
 * Une route est formée de segments, qui peuvent être obligatoire ou facultatif.
 * Un segment représente un fragment de l'uri càd chaine entre /
 *
 * @package LibreMVC\Routing
 */
class Route {

    public $name;

    public $pattern;
    public $controller;
    public $action;
    public $params;

    public function __construct( $pattern, $controller = null, $action = null, $params = null, $name = null ) {
        $this->pattern      = $pattern;
        $this->name         = $name;
        $this->controller   = $controller;
        $this->action       = $action;
        $this->params       = (is_null($params))? array() : $params;
    }

    public function getMandatorySegments() {
        $return = Array();
        foreach( $this->segments as $segment ) {
            if( $segment->mandatory ) {
                $return[$segment];
            }
        }
        return $return;
    }

    public function getSegments() {
        return $this->segments;
    }

    /**
     * Retourne la partie obligatoire d'une route.
     *
     * @return string
     */
    protected function extractMandatorySegment() {
        $crochetStart = strpos($this->pattern,"[");
        if( $crochetStart !== false ) {
            $mandatory = substr( $this->pattern, 0, $crochetStart );
        }
        else {
            $mandatory = $this->pattern;
        }
        return $mandatory;
    }

    public function mandatoryToArray() {
        $mandatory = $this->extractMandatorySegment();
        // 1 - Final slash ?
        $finalSlash = (substr($mandatory, -1) === '/') ? true : false ;

        $mandatoryAsArray = explode('/', trim($mandatory) );
        //var_dump($mandatory);
        $buffer = array();
        $j=0;
        foreach($mandatoryAsArray as $value){
            // Slash final
            if($value === '') {
                //$buffer[] = '/';
            }
            else {
                if($j !== 0) {
                    $buffer[] = '/';
                }
                $buffer[] = $value;
            }
            $j++;
        }
        if( $finalSlash ) {
            $buffer[] = '/';
        }
        return $buffer;
    }

    public function toArray() {
        $buffer = $this->pattern;
        $named = preg_match_all(
        //@todo a revoir mange le crochet fermant
        //"#\[{1}(.*)\]{1}#mU",
        //@todo a tester
            '#(\[:(.*)(\#\])|\[{1}(.*)\|\#\]$]{1})|\[{1}(.*)\]{1}#mU',
            $buffer,
            $match
        );

        return array_merge( $this->mandatoryToArray(), $match[0] )  ;
    }

    /**
     * @todo Voir class.uri.php toSegments, ISegmentable + AbstractSegment
     * @return array
     */
    public function toSegments() {
        $buffer = array();
        $segments = $this->toArray();
        foreach($segments as $segment) {
            $buffer[] = new Segment($segment, "");
        }
        return $buffer;
    }

    public function countSegments() {
        return count($this->toSegments());
    }

}