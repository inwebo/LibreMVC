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

class Informations {

    protected $toString;
    protected $header;
    protected $body;
    protected $dataProvider;
    protected $as;
    protected $recursive;

    protected function initialize($loop){

        // Representation sous forme de chaine d'une loop
        $this->toString = $loop['loop'];

        // Header
        $this->header = $loop['header'];

        // Body
        $this->body = $loop['body'];

        // DataProvider
        $this->dataProvider = $loop['dataProvider'];

        // Key value pair
        $this->as = array("key"=>$loop['key'], "value"=>$loop['value']);

        // IsRecursive
        $this->recursive = (bool)preg_match(Tag::LOOP, $this->body);

    }

    public function injectDataProviderName( $dataProviderName ) {

    }

    public function process( $loop ) {
        $this->initialize($loop);
        $results = new \StdClass();

        // Representation sous forme de chaine d'une loop
        $results->toString = $this->toString;

        // Header
        $results->header = $this->header;

        // Body
        $results->body = $this->body;

        // DataProvider
        $results->dataProvider = $this->dataProvider;

        // Key value pair
        $results->as = array("key"=>$this->as['key'], "value"=>$this->as['value']);

        // IsRecursive
        $results->recursive = (bool)preg_match(Tag::LOOP, $this->body);

        return $results;
    }

}