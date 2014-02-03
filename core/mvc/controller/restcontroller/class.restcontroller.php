<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 01/02/14
 * Time: 23:32
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Mvc\Controller;

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

class RestController extends Controller {

    protected $_cachable = false;
    protected $_public = true;
    protected $_reply;
    protected $_user;

    protected function init() {
        $this->_reply = new Reply();

        // Réponse est elle cachable ?
        if( !$this->_cachable ) {
            Header::noCache();
        }

        // Est ce un methode privée sans authentification
        if( !$this->_public && !$this->isLoginIn()) {
            Header::unauthorized();
            $this->_reply->msg ="Unauthorized acces";
            return;
        }

        $this->_user = new RestUser($this->_request->httpHeader->User, $this->_request->httpHeader->Token, $this->_request->httpHeader->Timestamp);

        // Mauvais utilisateur
        if( !$this->_public && !$this->validateRequest() ) {
            Header::unauthorized();
            $this->_reply->msg ="Unauthorized acces";
            return;
        }

        // Les actions du controller sont accessibles.

    }

    public function isLoginIn() {
        return ( isset( $this->_request->httpHeader->User ) && isset( $this->_request->httpHeader->Token ) && isset( $this->_request->httpHeader->Timestamp ));
    }

    public function indexAction(){
        $args = Environnement::this()->params;
        switch( $this->verb ) {
            //@todo options verb
            case 'options':
                // https://developer.mozilla.org/fr/docs/HTTP/Access_control_CORS !
                // X-domain
                break;

            case 'get':
                // Peuple variable globale
                parse_str(file_get_contents('php://input'), $_GET);
                $this->get($args);
                break;

            case 'post':
                // Peuple variable globale
                parse_str(file_get_contents('php://input'), $_POST);
                $this->post($args);
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

    protected function validateRequest() {
        // Requête sur les users
        return true;
    }

    protected function negotiateHttpContentType() {
        switch($this->_request->httpHeader->Accept) {
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

    public function __destruct() {
        switch($this->_request->httpHeader->Accept) {
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

}