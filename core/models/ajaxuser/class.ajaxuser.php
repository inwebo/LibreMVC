<?php

namespace LibreMVC\Models {

    class AjaxUser {

        public $user;
        public $publicKey;
        public $timeStamp;

        public function __construct($user,$publicKey,$timeStamp) {
            $this->user = $user;
            $this->publicKey = $publicKey;
            $this->timeStamp = $timeStamp;
        }

        static public function hashTimestamp($publicKey, $timestamp) {
            return sha1($publicKey,$timestamp);
        }

    }
}