<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 08/08/13
 * Time: 23:19
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Http\Rest;


class Reply {
    /**
     * @var bool
     */
    public $valid = true;

    /**
     * @var mixed
     */
    public $msg;

    /**
     * @var string
     */
    public $user;

    /**
     * @var string
     */
    public $token;

    /**
     * @var string
     */
    public $timestamp;

    public function __construct($msg = "", $user = null, $token = null, $timestamp = null) {
        $this->msg = $msg;
        $this->user = $user;
        $this->token = $token;
        $this->timestamp = $timestamp;
        return $this;
    }

    public function toJson() {
        return json_encode( $this );
    }

    //@todo
    public function toXml() {
        $dom = new \DOMDocument('1.0','UTF-8');
        $dom->formatOutput = true;
        $root = $dom->createElement("errors");

        $error = $dom->createElement("error");
        $errno = $dom->createElement("type", $this->errno);
        $errstr = $dom->createElement("message", $this->errstr);
        $errline = $dom->createElement('line', $this->errline);
        $context = $dom->createElement('context', $this->errcontext);

        $error->appendChild($errno);
        $error->appendChild($errstr);
        $error->appendChild($errline);
        $error->appendChild($context);
        $root->appendChild($error);
        $dom->appendChild($root);
        return $dom->saveXML();
    }

    public function toHtml() {
        return $this->msg;
    }

    public function toString() {
        return $this->msg;
    }

}