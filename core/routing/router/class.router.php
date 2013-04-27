<?php
/**
 * Created by JetBrains PhpStorm.
 * User: julien
 * Date: 22/04/13
 * Time: 13:09
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMCV\Routing;

use LibreMCV\Routing\UriParser as UriParser;

class Router {

    protected $uri;
    protected $routeCollection;

    public function __construct( $uri, $routeCollection, $asserts ) {
        $this->uri = $uri;
        $this->routeCollection = $routeCollection;
        $this->asserts = $asserts;
    }

    public function route() {
        $j=-1;
        while( isset( $this->routeCollection[++$j] ) ) {
            $parser = new UriParser($this->uri, $this->routeCollection[$j], $this->asserts);
            if( $parser->assertsResult['isNamedRoute'] === true || $parser->assertsResult['isValidPattern'] === true ) {
                return $parser->processPattern();
            }
        }

    }


}