<?php

namespace LibreMVC\Models;
use LibreMVC\Database\Entity;
class User extends Entity{

    /**
     * @var int
     */
    protected $id;
    /**
     * @var string
     */
    protected $login;
    /**
     * @var string
     */
    protected $mail;
    /**
     * @var string sha1
     */
    protected $password;
    /**
     * @var string sha1
     */
    protected $passPhrase;
    /**
     * @var string
     */
    protected $publicKey;
    /**
     * @var string
     */
    protected $privateKey;

    function __construct($login, $mail, $password, $passPhrase) {
        parent::__construct();
        $this->login = $login;
        $this->mail = $mail;
        $this->password = sha1($password);
        $this->passPhrase = sha1($passPhrase);
        $this->publicKey = $this->hashPublicKey();
        $this->privateKey = self::hashPrivateKey($this->login, $this->publicKey, $this->passPhrase);
    }

    protected function hashPublicKey() {
        return base64_encode( hash_hmac( "sha256", $this->login , $this->password . $this->login) );
    }

    static public function hashPrivateKey( $user, $publicKey, $passPhrase ) {
        return base64_encode( hash_hmac( "sha256", $user , $publicKey . $passPhrase ) ) ;
    }

}