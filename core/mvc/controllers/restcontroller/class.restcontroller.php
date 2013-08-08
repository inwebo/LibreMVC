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
use LibreMVC\Mvc\Controllers\PageController;
use LibreMVC\Http\Rest\Reply;

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
        $this->verb = Context::getHttpVerb();
        $this->negotiateHttpContentType();
        Header::noCache();
        $this->httpHeader = (object)apache_request_headers();
        $this->httpReply = new Reply();
        if($this->isLoginIn()) {
            $this->user      = $this->httpHeader->user;
            $this->token     = $this->httpHeader->Token;
            $this->timestamp = $this->httpHeader->Timestamp;
            $this->isValidUser();
        }


    }

    public function indexAction(  ){
        switch( strtolower($this->verb) ) {
            case 'get':
                $this->get();
                break;
            case 'post':
                $this->post();
                break;
            case 'update':
                $this->update();
                break;
            case 'delete':
                $this->delete();
                break;
        }
    }

    public function get() {
        echo __METHOD__;
    }

    public function post() {
        echo __METHOD__;
    }

    public function update() {
        echo __METHOD__;
    }

    public function delete() {

    }

    public function isLoginIn() {
        return ( isset( $this->httpHeader->User ) && isset( $this->httpHeader->Token ) && isset( $this->httpHeader->Timestamp ));
    }

    public function isValidUser() {

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