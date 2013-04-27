<?php

namespace LibreMVC\Models;

use LibreMVC\Database\Entity;
use LibreMVC\Database\Driver;
use LibreMVC\Models\Role;
use \stdClass;
use \PDO;

class User extends Entity {

    protected $id;
    public $login;
    public $name;
    public $role_id;
    public $publicKey;

    protected $roles;

    public function __construct() {
        parent::__construct();
        $this->table = $this->getTableName();
        $this->roles = array();
        $this->initRoles();
    }

    static public function getUserById($id) {
       $user = Driver::get("mysql")->select('*')->from('mvc_users')->where( 'id = ?', array($id) )->toObject('LibreMVC\Models\User')->fetchOne();
       return $user;
    }

    protected function initRoles() {
      if(!is_null($this->id) ) {
        $role = Driver::get('mysql')->query("SELECT t1.role_id, t2.role
                                             FROM mvc_user_role AS t1
                                             JOIN mvc_roles AS t2 ON t1.role_id = t2.id
                                             WHERE t1.user_id =?",array($this->id),array(PDO::FETCH_ASSOC));

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

    protected function toSession() {
        
    }

}