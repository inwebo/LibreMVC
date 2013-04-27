<?php

namespace LibreMVC\Models;

use LibreMVC\Database\Driver;
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
class Role {

    /**
     * Description
     *
     * @var type
     */
    protected $permissions;

    protected function __construct() {
        $this->permissions = array();
    }

    static public function getRolePermissions($role_id = 3) {
        $role = new Role();
        $row = Driver::get("mysql")->query("SELECT perm_id, description
                                            FROM mvc_role_perm AS T1
                                            JOIN mvc_permissions AS T2 ON T1.perm_id = T2.id
                                            WHERE T1.role_id =?", array($role_id), array(PDO::FETCH_ASSOC));
        $j = -1;
        while (isset($row[++$j])) {
            $role->permissions[$row[$j]['description']] = $row[$j]['perm_id'];
        }
        return $role;
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

