<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 06/08/13
 * Time: 21:31
 * To change this template use File | Settings | File Templates.
 */
//@todo yeah!
namespace LibreMVC\Mvc\Controllers;

use LibreMVC\Http\Context;
use LibreMVC\Http\Header;
use LibreMVC\Models\User;
use LibreMVC\Mvc\Controllers\PageController;
use LibreMVC\Http\Rest\Reply;
use LibreMVC\Http\Rest\Client;
use LibreMVC\Mvc\Environnement;

/**
 * Class RestController
 * @package LibreMVC\Mvc\Controllers
 * @todo Ne devrait pas étendre PageController
 */
class RestController extends  PageController {

    /**
     * @var string
     */
    public $verb;

    /**
     * @var object
     */
    public $httpHeader;
    /**
     * @var bool
     */
    protected $public = true;

    /**
     * @var string
     */
    protected $user;

    /**
     * @var string
     */
    protected $token;

    /**
     * @var string
     */
    protected $timestamp;

    /**
     * @var bool
     */
    protected $logged = false;

    protected $httpReply;


    public function __construct() {
        $this->verb = strtolower( Context::getHttpVerb() );
        $this->negotiateHttpContentType();
        Header::noCache();
        $this->httpHeader = (object)apache_request_headers();
        $this->httpReply = new Reply("");
        $this->setUser();
        $this->validateRequest();
    }

    protected function setUser() {
        if( $this->isLoginIn() ) {
            $this->user      = $this->httpHeader->User;
            $this->token     = $this->httpHeader->Token;
            $this->timestamp = $this->httpHeader->Timestamp;
        }
    }

    protected function validateRequest() {
        //$user = User::loadByPublicKey($this->user, $this->token);
        if( !$this->public ) {
            // Nécessite une authentification modification header
            if( !$this->isLoginIn() ) {
                Header::unauthorized();
                $this->httpReply->valid = false;
                $this->httpReply->msg = "Unauthorized request.";
            }
            // Essaye de se valider
            else {
                /*$a = $this->isValidUser("", "");
                var_dump( $a );
                echo($this->user. $this->token);*/
                //@todo ne comprends pas
                if( $this->isValidUser($this->user, $this->token) === false ) {
                    Header::badRequest();
                    $this->httpReply->valid = false;
                    $this->httpReply->msg = "Bad request.";
                }
                else {
                    $this->httpReply = new Reply("x", $this->user, Client::signature($this->user, md5("inwebo"), $this->timestamp), $this->timestamp);
                }
            }
        }
    }

    public function isLoginIn() {
        return ( isset( $this->httpHeader->User ) && isset( $this->httpHeader->Token ) && isset( $this->httpHeader->Timestamp ));
    }

    // Existe t-il un utilisateur avec ce login
    // Oui
    // est ce que sa publicKey + Passphrase == privateKey
    // Est ce que sa signature reste (user + password + timestamp) est identique a c'elle attendue
    //protected function isValidUser($login, $publicKey) {
    /*protected function isValidUser($login, $publicKey) {
        return true;
    }*/
    /**
     * Devrait être surchargé dans les classes filles
     * @return bool
     */
    protected function isValidUser(){
        //@todo Driver a revoir. Partage tous la m
        //var_dump(User::$_table);
        //$user = User::loadByPublicKey($this->user, "d46a1e7d07cb1bca68b501f85c803abc");
        //var_dump($user);
        return true;
    }

    /**
     * @todo Check si la méthode existe sinon 405 405 	Method Not Allowed
     */
    public function indexAction(){
        $args = Environnement::this()->params;
        switch( $this->verb ) {
            //@todo options
            case 'options':
                //var_dump('options');
                // https://developer.mozilla.org/fr/docs/HTTP/Access_control_CORS !
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
                $this->put($args);
                break;
        }
    }

    /**
     * Doit etre surchargée
     */

    public function get($args) {
        echo __METHOD__;
    }

    public function post($args) {
        echo __METHOD__;
    }

    public function update($args) {
        echo __METHOD__;
    }

    public function delete($args) {
        echo __METHOD__;
    }

    public function put($args) {
        echo __METHOD__;
    }


    public function negotiateHttpContentType() {
        switch($this->httpHeader->Accept) {

            case 'application/json':
                Header::json();
                break;

            case 'text/xml':
                Header::xml();
                break;

            case 'text/html':
                Header::html();
                break;

            default:
            case 'text/plain':
                Header::textPlain();
                break;

        }
    }

    public function __destruct() {
        switch($this->httpHeader->Accept) {
            case 'application/json':
                echo $this->httpReply->toJson();
                break;

            case 'text/xml':
                echo $this->httpReply->toXml();
                break;

            case 'text/html':
                echo $this->httpReply->toHtml();
                break;

            default:
            case 'text/plain':
                echo $this->httpReply->toString();
                break;
        }
    }

}