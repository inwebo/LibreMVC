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



    public $id;
    public $id_role;
    public $login;
    public $password;
    public $mail;
    public $publicKey;
    public $privateKey;
    protected $passPhrase;

    public $roles = array();
    public $permissions = array();

    static public $_primaryKey;
    static public $_table;
    static public $_tableDescription;
    static public $_statement;

    public function __construct( $login = null, $password=null, $passPhrase=null, $mail=null ) {
        if( !is_null($login)) {
            $this->login = $login ;
        }
        if( is_null($this->id)) {
            $this->id = DEFAULT_ID_USER ;
        }
        if( !is_null($mail) ) {
            $this->mail = $mail;
        }

        $this->password = $this->generateHash($password);
        $this->passPhrase = $this->generateHash($passPhrase);
        $this->publicKey = $this->hashPublicKey($this->login, $this->password);
        $this->privateKey = $this->hashPrivateKey($this->login, $this->publicKey, $this->passPhrase);
        $this->id_role = DEFAULT_ID_ROLE;
        $this->roles = $this->getRolesByIdUser();

        // Id par default de tous les roles
        $this->permissions = Role::getRolePermissions($this->id_role);

    }

    /**
     * N'est pas son job
     * @param $user
     * @param $mdp
     * @param bool $get
     * @return bool
     */
    static public function isValidUser( $user, $mdp, $get = true ) {
        $class = get_called_class();
        $class::$_statement->toObject($class);
        try {
            $result = $class::$_statement->query('SELECT * FROM Users WHERE login = ? AND password = ? ', array($user, md5($mdp)))->first();
        }
        catch(\Exception $e) {
            var_dump($e);
        }
        $isValid = isset($result) && !is_null($result) && !empty($result);
        if($get && $isValid) {
            return $result;
        }
        else {
            return $isValid;
        }
        return isset($result) && !is_null($result) && !empty($result);
    }

    static public function loadByPublicKey($user, $publicKey) {
        $class = get_called_class();
        $class::$_statement->toObject($class);
        $user =  $class::$_statement->query('SELECT * FROM Users WHERE login = ? AND publicKey = ? ', array($user, $publicKey))->first();
        //$user = $class::$_statement->query('SELECT * FROM Users WHERE login = ? AND publicKey = ? ', array($user, $publicKey))->first();
        //var_dump($user);
        return $user;
    }

    static public function isValidRestQuery($user, $publicKey) {
        /**
         * - Est un utilisateur connus
         */
    }

    /*
    static public function loadByPublicKey( $user, $publicKey, $get = true ) {
        $class = get_called_class();
        $class::$_table = 'Users';
        $class::$_statement->toObject($class);
        //var_dump($class);
        try{
            $result = $class::$_statement->query('SELECT * FROM Users WHERE login = ? AND publicKey = ? ', array($user, $publicKey))->first();
        }
        catch(\Exception $e) {
            //var_dump($e);
        }
        $isValid = isset($result) && !is_null($result) && !empty($result);
        if($get && $isValid) {
            return $result;
        }
        else {
            return $isValid;
        }
        //return isset($result) && !is_null($result) && !empty($result);
    }
*/
    /**
     * Get user's roles by id user
     * @return mixed
     */
    protected function getRolesByIdUser() {
        $class = get_called_class();
        $class::$_table = 'Users';
        $query = "SELECT t1.id_role, t2.type FROM ". $class::$_table ." AS t1 JOIN Roles AS t2 ON t1.id_role = t2.id WHERE t1.id =?";
        if(!is_null($this->id) ) {
            $class::$_statement->toStdClass();
            $role = $class::$_statement->query($query, array( $this->id ) )->All();

        }
        return $role;
    }


    public function hasRole( $idRole ) {
        if( $this->roles->count() > 0 ) {
            $this->roles->rewind();
            while($this->roles->valid()) {
                if( $this->roles->current()->id == $idRole) {
                    return true;
                }
                $this->roles->next();
            }
        }
        else {
            return false;
        }
    }

    public function hasPermission( $idPermission ) {
        if( $this->permissions->count() > 0 ) {
            $this->permissions->rewind();
            while($this->permissions->valid()) {
                if( $this->permissions->current()->description == $idPermission) {
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

    static public function generateHash( $password ) {
        // Snippet will crypt any chars
        //return hash_hmac("sha256", $password, ""  );
        /*if (defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH) {
            $salt = '$2y$11$' . substr(md5(uniqid(rand(), true)), 0, 22);
            return crypt($password, $salt);
        }*/
        return sha1( $password );
    }

    /**
     * @param $login string Plain text
     * @param $password string MD5 string
     * @return string string MD5 Public key
     */
    static public function hashPublicKey( $login, $password ) {
        return sha1( $login . $password );
    }

    static public function hashPrivateKey( $user, $password, $passPhrase ) {
        return  base64_encode( hash_hmac( "sha256", $user , $password . $passPhrase ) ) ;
    }

    static public function compareKeys( $key1, $key2 ) {
        return $key1 === $key2;
    }

}