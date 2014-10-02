<?php

namespace LibreMVC\Models;

use LibreMVC\Database\Entity;
use LibreMVC\Database\Driver;
use LibreMVC\Models\Role;
use LibreMVC\Mvc\Environnement;
use \PDO;

const DEFAULT_ID_ROLE = 4;
const DEFAULT_ID_USER = 0;

class User extends Entity {

    /**
     * @var int
     */
    public $id;
    /**
     * @var int
     */
    public $id_role;
    /**
     * @var string
     */
    public $login;
    /**
     * @var string sha1
     */
    public $password;
    /**
     * @var string
     */
    public $mail;
    /**
     * @var string sha1
     */
    public $passPhrase;
    /**
     * @var string
     */
    public $publicKey;
    /**
     * @var string
     */
    public $privateKey;
    /**
     * @var array
     */
    public $roles = array();
    /**
     * @var array
     */
    public $permissions = array();

    static public $_primaryKey;
    static public $_table;
    static public $_tableDescription;
    static public $_statement;

    public function __construct() {
        if(!is_null($this->id)) {
            $this->roles = $this->getUserRoles($this->id);
            $this->permissions = Role::getRolePermissions($this->id_role);
        }
    }

/*
    public function __construct( $login, $password, $passPhrase, $mail ) {

        $this->login = $login;
        $this->password = $this->hash( $password );
        $this->passPhrase = $this->hash( $passPhrase );
        var_dump($mail);
        $this->mail=$mail;
        $this->publicKey = $this->hashPublicKey( $this->login, $this->password );
        $this->privateKey = $this->hashPrivateKey( $this->login, $this->publicKey, $this->passPhrase );
        $this->id_role = DEFAULT_ID_ROLE;
        $this->roles = $this->getUserRoles($this->id);

        // Id par default de tous les roles
        $this->permissions = Role::getRolePermissions($this->id_role);

    }
*/
    public function getUserRoles($idUser) {
        $class = get_called_class();
        $class::$_table = 'Users';
        $query = "SELECT t1.id_role, t2.type FROM ". $class::$_table ." AS t1 JOIN Roles AS t2 ON t1.id_role = t2.id WHERE t1.id =?";
        if(!is_null($idUser) ) {
            $class::$_statement->toStdClass();
            $role = $class::$_statement->query($query, array( $idUser ) )->All();
        }
        return $role;
    }

    static public function factory( $login, $pwd, $pass, $role = 1) {
        $u = new User();
        $u->login = $login;
        $u->password = sha1($pwd);
        $u->passPhrase = sha1($pass);
        $u->publicKey = self::hashPublicKey($u->login, $u->password);
        $u->privateKey = self::hashPrivateKey($u->login, $u->publicKey,$u->passPhrase);
        $u->id_role = 1;
        return $u;
    }

    /**
     * @param $user User login.
     * @param $password User password, must be a sha1.
     * @return bool Couple login/password exists
     */
    static public function isValidUser($user, $password) {
        $class = get_called_class();
        $class::$_table = 'Users';
        $params = array($user, $password);
        $query = "SELECT login, password FROM " .  $class::$_table . " WHERE login=? and password=?";
        $user = $class::$_statement->query($query, $params)->first();
        return (is_null($user)) ? false : true;
    }

    public function hasRole( $idRole ) {
        if( $this->roles->count() > 0 ) {
            $this->roles->rewind();
            while($this->roles->valid()) {
                if( $this->roles->current()->id_role == $idRole) {
                    return true;
                }
                $this->roles->next();
            }
            return false;
        }
        else {
            return false;
        }
    }

    public function hasPermission( $idPermission ) {
        if( $this->permissions->count() > 0 ) {
            $this->permissions->rewind();
            while($this->permissions->valid()) {
                if( $this->permissions->current()->id_perm == $idPermission) {
                    return true;
                }
                $this->permissions->next();
            }
        }
        else {
            return false;
        }

        return isset( $this->roles[$idPermission] );
    }

    static public function hash( $string ) {
        return sha1( $string );
    }

    /**
     * @param $login
     * @param $password
     * @return string
     */
    static public function hashPublicKey( $login, $password ) {
        return sha1( $login . $password );
    }

    static public function hashPrivateKey( $user, $publicKey, $passPhrase ) {
        return  base64_encode( hash_hmac( "sha256", $user , $publicKey . $passPhrase ) ) ;
    }

    static public function compareKeys( $key1, $key2 ) {
        return $key1 === $key2;
    }

}