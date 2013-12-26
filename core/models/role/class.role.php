<?php

namespace LibreMVC\Models;

use LibreMVC\Database\Driver;
use LibreMVC\Database\Entity;
use \stdClass;
use \PDO;

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description courte
 *
 * Description longue
 *
 * @category   LibreMVC
 * @package    View
 * @subpackage Template
 * @copyright  Copyright (c) 1793-2222 Inwebo Veritas (http://www.inwebo.net)
 * @license    http://framework.zend.com/license   BSD License
 * @version    $Id:$
 * @link       https://github.com/inwebo/Template
 * @since      File available since Beta
 */
class Role extends Entity{

    protected $id;
    protected $type;

    protected $permissions;

    static public $_primaryKey;
    static public $_table;
    static public $_tableDescription;
    static public $_statement;

    protected function __construct() {

    }

    static public function getRolePermissions($role_id) {
        $class = get_called_class();
        $query = "SELECT id_role, id_perm, description FROM role_perm AS T1 JOIN Permissions AS T2 ON T1.id_perm = T2.id WHERE T1.id_role =?";
        //var_dump($class::$_statement);
        $permissions = $class::$_statement->query($query, array( $role_id) )->All();
        return($permissions);
    }

    public function hasPermission($permission) {
        return property_exists($this->permissions, $permission);
    }

    public function __set($attribut, $value) {
        $this->$attribut = $value;
    }

    public function __get($attribut) {
        if (property_exists($this, $attribut)) {
            return $this->$attribut;
        }
    }

}

