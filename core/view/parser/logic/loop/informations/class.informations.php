<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 13/01/14
 * Time: 23:18
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\View\Parser\Logic\Loop;

use LibreMVC\View\Parser\Logic;
use LibreMVC\View\Parser\Tag;

class Informations extends Logic {

    protected $toString;
    protected $header;
    protected $body;
    protected $dataProvider;
    protected $as;
    protected $bodyVars;
    protected $recursive;

    protected function initialize($loop){
        // Representation sous forme de chaine d'une loop
        $this->toString = $loop;

        // Header
        preg_match( Tag::LOOP_HEADER, $loop, $header );
        $this->header = $header[0];

        // Body
        preg_match( Tag::LOOP_BODY, $loop, $innerLoop );
        $this->body = $innerLoop[1];

        // DataProvider
        preg_match(Tag::LOOP_ITERABLE, $this->header, $dataProvider);
        $this->dataProvider = $dataProvider[1];

        // Key value pair
        preg_match( Tag::LOOP_AS , $this->header, $keyValue );
        $this->as = array("key"=>$keyValue[1], "value"=>$keyValue[2]);

        // Body vars
        preg_match( Tag::LOOP_BODY_VARS, $this->body, $buffer );

        $this->bodyVars = (isset($buffer[1])) ? $buffer[1] : null;

        // IsRecursive
        $this->recursive = (bool)preg_match(Tag::LOOP, $loop);

    }

    public function injectDataProviderName( $dataProviderName ) {

    }

    public function process( $loop ) {
        $this->initialize($loop);
        $results = new \StdClass();

        // Representation sous forme de chaine d'une loop
        $results->toString = $loop;

        // Header
        preg_match( Tag::LOOP_HEADER, $loop, $header );
        $results->header = $header[0];

        // Body
        preg_match( Tag::LOOP_BODY, $loop, $innerLoop );
        $results->body = $innerLoop[1];

        // DataProvider
        preg_match(Tag::LOOP_ITERABLE, $results->header, $dataProvider);
        $results->dataProvider = $dataProvider[1];

        // Key value pair
        preg_match( Tag::LOOP_AS , $results->header, $keyValue );
        $results->as = array("key"=>$keyValue[1], "value"=>$keyValue[2]);

        // Body vars
        preg_match( Tag::LOOP_BODY_VARS, $results->body, $buffer );

        $results->bodyVars = (isset($buffer[1])) ? $buffer[1] : null;

        // IsRecursive
        $results->recursive = (bool)preg_match(Tag::LOOP, $loop);

        return $results;
    }

}