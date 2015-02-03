<?php
/**
 * Created by PhpStorm.
 * User: inwebo
 * Date: 02/02/15
 * Time: 20:07
 */

namespace LibreMVC\Models;


class AjaxResponse {
    /**
     * @var bool
     */
    public $valid = true;

    /**
     * @var mixed
     */
    public $data;

    public $error = null;

    public function __construct($data=null) {
        $this->data = $data;
        return $this;
    }

    public function toJson() {
        return json_encode( $this );
    }

    public function toXml() {
        $dom               = new \DOMDocument('1.0','UTF-8');
        $dom->formatOutput = true;
        $reply             = $dom->createElement("reply");

        $msg       = $dom->createElement( "valid", $this->valid );
        $error      = $dom->createElement( "error", $this->error );
        $data      = $dom->createElement( "data", $this->data );


        $reply->appendChild( $msg );
        $reply->appendChild( $error );
        $reply->appendChild( $data );

        $dom->appendChild( $reply );
        return $dom->saveXML();
    }

    public function toHtml() {
        return $this->data;
    }

    public function toString() {
        return $this->data;
    }
}