<?php
/**
 * Created by JetBrains PhpStorm.
 * User: julien
 * Date: 22/04/13
 * Time: 13:09
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Routing;

use LibreMVC\Http\Context;
use LibreMVC\Http\Header;
use LibreMVC\Mvc\Environnement;
use LibreMVC\Routing\UriParser as UriParser;

class Router {

    protected $uri;
    protected $routeCollection;

    public function __construct( $uri, $routeCollection, $asserts ) {
        $this->uri = $uri;
        $this->routeCollection = $routeCollection;
        $this->asserts = $asserts;
    }

    public function dispatch() {
        $j = -1;
        while( isset( $this->routeCollection[++$j] ) ) {
            $parser = new UriParser( $this->uri, $this->routeCollection[$j], $this->asserts );
            // @todo developper cette partie finement
            /**
             * @important Est nécessaire pour garder l'unicité des uris. elles doivent être uniques.
             */
            if($parser->assertsResult['isUriGreaterThanRoute']) {
                return null;
            }

            if( $parser->assertsResult['isNamedRoute'] ) {
                // Redirection, unicité des routes
                Header::movedPermanently();
                header('Location: ' . Context::getServer( true, true ) .$this->routeCollection[$j]->pattern);
                return $this->routeCollection[$j];
            }

            if( $parser->assertsResult['isValidPattern'] ) {
                return $parser->processPattern();
            }

        }

    }


}