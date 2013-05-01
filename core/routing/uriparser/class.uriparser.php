<?php
/**
 * Created by JetBrains PhpStorm.
 * User: julien
 * Date: 22/04/13
 * Time: 13:08
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMCV\Routing;

// Doit renvoyer les segments obligatoire, facultatifs
// Appliques toutes les methodes des asserts sur l'uri courante.

class UriParser {

    protected $uri;
    protected $route;

    /**
     * @var object $asserts Un objet contenant les assertions à valider
     */
    protected $assertsObject;

    /**
     * @var array Tableau associatif sous la forme :
     * <code>
     * array(
     *    "nomDeLassertion" => result
     * );
     * <code>
     */
    public $assertsResult = array();

    public function __construct( $uri, $route, $asserts ) {
        $this->uri = $uri;
        $this->route = $route;
        $this->assertsObject = $asserts;
        $this->assertions();
    }

    public function assertions() {
        $methods = get_class_methods($this->assertsObject);
        foreach( $methods as  $member ) {
            // Doit commencer par is, est donc une assertion
            $isAssert = !strncmp($member, "is", strlen("is"));;

            // Invoke l'assertion avec les bons arguments.
            if($isAssert) {
                $reflectAssertions = new \ReflectionMethod($this->assertsObject, $member);
                $this->assertionInvoker($reflectAssertions);
            }
        }
    }

    protected function assertionInvoker( $reflect ) {
        $arguments = $reflect->getParameters();
        if( count( $arguments ) === 1 ) {
            $result = $reflect->invoke( $reflect->name, $this->uri);
        }
        else {
            $result = $reflect->invoke( $reflect->name, $this->uri, $this->route);
        }
        $this->assertsResult[$reflect->name] = $result;
        return $result;
    }

    public function isValidRoute() {
        $valid = true;
        foreach($this->assertsResult as $value) {
            $valid = $valid || $value;
        }
        return $valid;
    }

    public function processPattern( $strictMode = true ) {
        $uriArray = $this->uri->toArray();
        $patternArray = $this->route->patternToArray();

        $params = array();
        $j = 0;
        foreach( $patternArray as $value ) {

            $facultative = ( is_int( strpos( $value, '[' ) ) ) ? true : false;

            if( $facultative !== false ) {

                if( isset( $uriArray[$j] ) && $uriArray[$j] !== "/" ) {
                    switch( $value ) {
                        case "[:controller]":
                            $this->route->controller = $uriArray[$j];
                            break;

                        case "[:action]":
                            $this->route->action = $uriArray[$j];
                            break;

                        case '[:id]':
                            $params[] = $uriArray[$j];
                            break;

                        default:
                            break;
                    }

                    if( strpos( $value, '[:id|' ) !== false ) {
                        $parmName = explode( '|', $value );
                        $params[trim($parmName[1],']')] = $uriArray[$j];
                    }
                }
                $this->route->params = $params;
            }

            $j++;
        }
        return $this->route;
    }

}