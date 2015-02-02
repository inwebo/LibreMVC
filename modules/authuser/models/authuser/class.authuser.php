<?php

namespace LibreMVC\Modules\AuthUser\Models {

    use LibreMVC\Models\User;
    use LibreMVC\Models\User\Role\Filters\RoleFilter;
    use LibreMVC\Models\User\Role\Filters\PermissionFilter;

    class AuthUser extends User{

        const MODEL_ROLE = "\\LibreMVC\\Models\\User\\Role";

        const SQL_SELECT_ROLES = "SELECT t1.id, t1.id_role, t2.type FROM %s AS t1 JOIN Roles AS t2 ON t1.id_role = t2.id WHERE t1.id =?";

        protected $_roles;
        public $id_role;

        public function init() {
            parent::init();
            // Config db
            $this->_roles = $this->initRoles();
        }

        public function initRoles() {
            $conf = $this->getConf();
            $query = "SELECT t1.id, t1.id_role, t2.type FROM ". $conf->table ." AS t1 JOIN Roles AS t2 ON t1.id_role = t2.id WHERE t1.id =?";
            $conf->driver->toObject(self::MODEL_ROLE);
            $role = $conf->driver->query($query, array( $this->id_role ) )->All();
            return $role;
        }

        public function hasRole($id){
            $iterator=  new \ArrayObject($this->_roles);
            $filtered = new RoleFilter($iterator->getIterator(),$id);
            $filtered->rewind();
            while($filtered->valid()) {
                return true;
            }
            return false;
        }

        public function is($roleName) {
            $iterator=  new \ArrayObject($this->_roles);
            $filtered = new User\Role\Filters\RoleFilter\ByName($iterator->getIterator(),$roleName);
            $filtered->rewind();
            while($filtered->valid()) {
                return true;
            }
            return false;
        }

        public function hasPermission($id){
            $iterator=  new \ArrayObject();
            while($this->_roles->valid()) {
                $iterator->append($this->_roles->current());
                $this->_roles->next();
            }
            $filtered = new PermissionFilter($iterator->getIterator(),$id);
            $filtered->rewind();
            while($filtered->valid()) {
                return true;
            }
            return false;
        }

        public function has($permissionName) {

        }

        static public function loadByIdPwd( $id, $pwd ) {
            $conf = static::$_entityConfiguration;
            $sql = 'SELECT * FROM %s WHERE login=? AND password=?';
            $sql = sprintf($sql,$conf->table);
            $conf->driver->toObject(__CLASS__);
            $user = $conf->driver->query($sql,array($id,$pwd))->first();
            return $user;
        }

        public function getRoles() {
            return $this->_roles;
        }
    }
}