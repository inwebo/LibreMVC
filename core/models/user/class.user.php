<?php

namespace LibreMVC\Models;

use LibreMVC\Database\Entity;
use LibreMVC\Database\Driver;
use LibreMVC\Models\Role;
use LibreMVC\Mvc\Environnement;
use \PDO;

class User extends Entity {

    public $id;
    public $id_role;
    public $login;
    public $password;
    protected $mail;
    public $publicKey;
    protected $passPhrase;

    public $roles = array();
    public $permissions = array();

    static public $_primaryKey;
    static public $_table;
    static public $_tableDescription;
    static public $_statement;

    public function __construct() {
        $this->roles = $this->getRoles();
        $this->permissions = Role::getRolePermissions(4);
        $class = get_called_class();
        $class::$_table = 'Users';
    }

    static public function isValidUser( $user, $mdp, $get = true ) {
        $class = get_called_class();
        $class::$_statement->toObject($class);
        try {
        $result = $class::$_statement->query('SELECT * FROM Users WHERE login = ? AND password = ? ', array($user, md5($mdp)))->first();
        }
        catch(\Exception $e) {

//            var_dump($e);
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

    static public function loadByPublicKey( $user, $publicKey, $get = true ) {
        $class = get_called_class();
        $class::$_table = 'Users';
        $class::$_statement->toObject($class);
        //var_dump($class);
        try{
            $result = $class::$_statement->query('SELECT * FROM Users WHERE login = ? AND publicKey = ? ', array($user, $publicKey))->first();
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

    protected function getRoles() {
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

    /**
     * @param $login string Plain text
     * @param $password string MD5 string
     * @return string string MD5 Public key
     */
    static public function hashPublicKey( $login, $password ) {
        return md5( $login . $password );
    }

    static protected function hashPrivateKey( $login, $password, $passPhrase ) {
        return md5( md5( $login, $password ) . $passPhrase );
    }

    static public function compareKeys( $key1, $key2 ) {
        return $key1 === $key2;
    }

}