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

    public function __construct() {
        $this->roles = $this->getRoles();
        $this->permissions = Role::getRolePermissions(4);
    }

    static public function isValidUser( $user, $mdp ) {
        $class = get_called_class();
        $result = $class::$_statement->query('SELECT * FROM users WHERE login = ? AND password = ? ', array($user, md5($mdp)))->first();
        return isset($result) && !is_null($result) && !empty($result);
    }

    protected function getRoles() {
        $class = get_called_class();
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

    static public function compareKeys( $privateKey, $publicKey ) {
        return $privateKey === $publicKey;
    }

}