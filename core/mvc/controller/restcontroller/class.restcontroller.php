<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 01/02/14
 * Time: 23:32
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Mvc\Controller;

use LibreMVC\Models\User;
use LibreMVC\Mvc\Controller;
use LibreMVC\Http\Header;
use LibreMVC\Http\Rest\Reply;

class RestUser {

    public $user;
    public $token;
    public $timeStamp;

    public function __construct($user,$token,$timeStamp) {
        $this->user = $user;
        $this->token = $token;
        $this->timeStamp = $timeStamp;
    }

}

/**
 * Class RestController
 * @package LibreMVC\Mvc\Controller
 */
class RestController extends Controller{

    /**
     * @var bool Le resultat de la requête doit il être mis en cache ?
     */
    protected $_cachable = false;
    /**
     * @var bool Le service nécessite il une requête signée.
     */
    protected $_public = true;
    /**
     * @var \Reply L'objet de réponse
     */
    protected $_reply;
    /**
     * @var User L'utilisateur courant.
     */
    protected $_user;

    /**
     * @var string To set
     * @todo TO SET to prod
     */
    protected $_salt = "salt";

    public $_INPUTS;

    public function __construct( Request $request, $view = null ) {
        $this->_request = $request;
        $this->init();
    }
    protected function init() {
        $this->_reply = new Reply();
        // Réponse est elle cachable ?
        if( !$this->_cachable ) {
            Header::noCache();
        }
        // Est ce un methode privée sans authentification
        if( !$this->_public && !$this->isLoginIn()) {
            $this->unauthorized();
            Header::badRequest();
        }
        if( !$this->_public ) {

            $this->_user = new RestUser( $this->_request->httpHeader['User'],
                                         $this->_request->httpHeader['Token'],
                                         $this->_request->httpHeader['Timestamp']
            );


        }

        // Mauvais utilisateur
        if( !$this->_public && !$this->validateRequest() ) {

            $this->unauthorized();
        }

        $this->negotiateHttpContentType();

        // indexAction disponible

        // Peuple.
        parse_str(file_get_contents('php://input'), $this->_INPUTS);
    }

    /**
     * Accés interdit.
     */
    protected function unauthorized() {
        Header::unauthorized();
        $this->_reply->msg ="Unauthorized acces";
        exit;
    }

    /**
     * Est ce une requête signée ?
     * @return bool
     */
    public function isLoginIn() {
        //var_dump($this);
        //var_dump( isset( $this->_request->httpHeader['User'] ) && isset( $this->_request->httpHeader['Token'] ) && isset( $this->_request->httpHeader['Timestamp'] ));
        return ( isset( $this->_request->httpHeader['User'] ) && isset( $this->_request->httpHeader['Token'] ) && isset( $this->_request->httpHeader['Timestamp'] ));
    }

    /**
     * Definit le ContentTpe du header selon la demande du client.
     */
    protected function negotiateHttpContentType() {
        switch($this->_request->httpHeader['Accept']) {
            case 'application/json':
                Header::json();
                break;

            case 'text/xml':
                Header::xml();
                break;

            default:
            case 'text/html':
                Header::html();
                break;

            case 'text/plain':
                Header::textPlain();
                break;
        }
    }

    /**
     * Doit être le point d'entré du controller, 1 controller === une action avec les différents verbes supportés.
     * Peuple les variables globales.
     * @
     * @param $args
     */
    public function indexAction($args){
        // @todo : Les variables globales $_GET, $_POST devraient être dans une var global $_INPUT
        switch( strtolower($this->_request->verb ) ) {
            //@todo options verb
            case 'options':
                // https://developer.mozilla.org/fr/docs/HTTP/Access_control_CORS !
                // X-domain
                break;
            /**
             * ESt inutile recuperation variable depuis le frontcontroller
             */
            // @todo : A nettoyer parse_str
            case 'get':
                // Peuple variable globale
                parse_str(file_get_contents('php://input'), $_GET);
                $this->get($args);
                break;

            case 'post':
                // Peuple variable globale
                parse_str(file_get_contents('php://input'), $_POST);
                $this->post($_POST);
                break;

            case 'update':
                $this->update($args);
                break;

            case 'delete':
                $this->delete($args);
                break;

            case 'put':
                parse_str(file_get_contents('php://input'), $_POST);
                $this->put($args);
                break;
        }
    }

    public function options() {
        //echo __METHOD__;
    }

    public function get($args) {
        //echo __METHOD__;        var_dump($this);
    }

    public function post($args) {
        //echo __METHOD__;
    }

    public function update($args) {
        //echo __METHOD__;
    }

    public function delete($args) {
        //echo __METHOD__;
    }

    public function put($args) {
        //echo __METHOD__;
    }

    /**
     * Une requête HTTP est elle valide ?
     *
     * @return bool
     */
    protected function validateRequest() {
        $user = User::load($this->_user->user,'login');
        // L'utilisateur n'existe pas.
        if(is_null($user)) {
            $this->unauthorized();
        }
        else {
            // Il existe
            // Et comparaison avec le timestamp est valide
            if( User::hash( $this->_user->token .
                            $this->_user->timestamp .
                            $this->_salt ) === User::hash(
                                                            $user->publicKey .
                                                            $this->_user->timestamp .
                                                            $this->_salt ) ) {

                // Et sa clef privé est valide.
                if( self::comparePublicPrivateKeys( $this->_user->login, $this->_user->token, $user ) ) {
                    // Continue
                    return true;
                }
                else {
                    $this->unauthorized();
                }
            }
            else {
                $this->unauthorized();
            }
        }

        return true;
    }

    static function comparePublicPrivateKeys($login, $publicKey, User $user) {
        //var_dump($user::hashPrivateKey($login, $publicKey, $user->passPhrase) );
        //var_dump($user->privateKey);
        return (int) $user::hashPrivateKey($login, $publicKey, $user->passPhrase) == $user->privateKey;
    }

    /**
     * A la destruction de l'objet affichage de la réponse au format définit dans $this->_request->httpHeader->Accept
     */
    public function __destruct() {
        switch($this->_request->httpHeader['Accept']) {
            case 'application/json':
                echo $this->_reply->toJson();
                break;

            case 'text/xml':
                echo $this->_reply->toXml();
                break;

            case 'text/html':
                echo $this->_reply->toHtml();
                break;

            default:
            case 'text/plain':
                echo $this->_reply->toString();
                break;
        }
    }

    public function getVerb() {
        return strtolower($this->_request->verb);
    }

}