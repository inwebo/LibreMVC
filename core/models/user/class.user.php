<?php

namespace LibreMVC\Models;

use LibreMVC\Database\Entity;
use LibreMVC\Database\Driver;
use LibreMVC\Models\Role;
use LibreMVC\Mvc\Environnement;
use \PDO;

class User extends Entity {

    protected $id;
    public $id_role;
    public $login;
    public $password;
    public $mail;

    protected $roles = array();

    public function __construct($id = null) {
        parent::__construct();
        $this->id = $id;
        User::orm(Environnement::this()->_dbSystem, 'users','id');
        $this->initRoles();
    }

    static public function getById( $id ) {
       //$user = self::$_dbResource->select('*')->from(User::$_table)->where( 'id = ?', array($id) )->fetchOne();
       //return self::$_dbResource->select('*')->from('users')->where( 'id = ?', array($id) )->toObject('LibreMVC\Models\User')->fetchOne();
       $result = self::$_dbResource->query('SELECT * FROM users WHERE id = ?', array($id));
       return (isset($result[0])) ? $result[0] : null;
       //return $user;
    }

    static public function isValidUser( $user, $mdp ) {
        $result = self::$_dbResource->query('SELECT * FROM users WHERE login = ? AND password = ? ', array($user, md5($mdp)));
        return isset($result[0]);
    }

    protected function initRoles() {
      if(!is_null($this->id) ) {
        /*$role = Driver::get('mysql')->query("SELECT t1.role_id, t2.role
                                             FROM users AS t1
                                             JOIN roles AS t2 ON t1.role_id = t2.id
                                             WHERE t1.user_id =?",array($this->id),array(PDO::FETCH_ASSOC));*/
          $role = self::$_dbResource->query('
                                                SELECT t1.id_role, t2.role
                                                FROM '. User::$_table .' AS t1
                                                JOIN roles AS t2 ON t1.id_role = t2.id
                                                WHERE t1.user_id =?
                                                ', array($this->id));
        $j = -1;
        while(isset($role[++$j])) {
            $roles = Role::getRolePermissions($role[$j]['role_id']);
            foreach ($roles->permissions as $key => $value) {
                $this->roles[$key] = $value;
            }
        }
      }
    }

    public function hasPrivilege( $permission ) {
        return isset( $this->roles[$permission] );
    }

}