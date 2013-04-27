<?php
namespace LibreMVC\Http;

use LibreMVC\Controllers;
use LibreMVC\Http\Route as Route;
use LibreMVC\Http\Header as Header;
/**
 * Construit le router / methode courante.
 * @todo Ajouter les headers http (404 si la vue n'existe pas, 403 si RBAC est 
 * négatif.
 */

class UrlHandler {

    /**
     * Les paramétres associés à l'url courante. Par défaut est un tableau null.
     * @var array 
     */
    static protected $params;

    private function __construct() {}     
    
    static public function processRequest( /*$controller = CONTROLLER , $action = ACTION, $params = PARAMS*/) {
        self::$params = unserialize(PARAMS);
        
        // Est une route valide
        //if(!Route::isRoute( md5( INSTANCE.CONTROLLER.ACTION ) ) ) {
            //\LibreMVC\Http\Header::notFound();
        //}
        
        // est un controller valide
        if ( self::isController( PATH_CURRENT_CONTROLLER ) ) {
            include PATH_CURRENT_CONTROLLER;
            $controller =  'LibreMVC\\Controllers\\'.ucfirst(CONTROLLER) . "Controller";
            $newAction = new $controller;
            $m = ACTION;
            //var_dump(self::gotMethod($controller, ACTION));
            // est une methode de controller valide.
            if( method_exists($newAction, $m) ) {
                $params = unserialize(PARAMS);
                
                if(is_null($params) ){
                    $newAction->$m();    
                }
                else {
                    call_user_func_array(
                    array($newAction, $m),
                        unserialize(PARAMS)
                    );
                }
            }
            else {
                Header::notFound();
            }
        }
        else {
            Header::notFound();
        }
    }

    static public function gotMethod($class, $method) {
        $reflexion = new \ReflectionClass($class);
        try {
            $methods = $reflexion->getMethod($method);
        }
        catch ( \Exception $e ) {
            
        }
        return ( is_null( $methods ) ) ? false : true;
    }

    /**
     * La vue courante existe t elle ? Càd le fichier est il bien présent sur le
     * serveur.
     *
     * @return Bool True si le fichier existe sinon false
     */
    static public function isView() {
        return is_file( PATH_CURRENT_VIEW );
    }

    /**
     * L'action existe t elle ?
     * @param string $controller Le chemin d'un fichier controller
     * @return bool True si le fichier existe sinon false
     */
    static protected function isController($controller) {
        return is_file($controller);
    }

    /**
     * Setter
     * @param string $member
     * @param string $value
     */
    public function __set($member, $value) {
        $this->$member = $value;
    }

    /**
     * Getter
     * @param string $attribut
     * @return Mixed
     */
    public function __get($attribut) {
        if (property_exists($this, $attribut)) {
            return $this->$attribut;
        }
    }
}