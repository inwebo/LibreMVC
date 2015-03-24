<?php
/**
 * Created by PhpStorm.
 * User: inwebo
 * Date: 12/03/15
 * Time: 17:26
 */

namespace LibreMVC\Mvc\Controller\Traits {


    trait Authentification
    {

        /**
         * @var AuthUser
         */
        protected $_sessionUser;
        /**
         * @var array Nom des roles autorisés, null si tous
         */
        protected $_roles;
        /**
         * @var array Id des permissions autorisées, null si toutes
         */
        protected $_permissions;


        protected function validateRequest()
        {
            if (!$this->validateRoles()) {
                return false;
            } else {
                if (!$this->validatePerms()) {
                    return false;
                }
            }
            return true;
        }

        protected function validateRoles()
        {
            if (is_null($this->_roles)) {
                return true;
            } elseif (is_array($this->_roles)) {
                $valid = true;
                foreach ($this->_roles as $role) {
                    $valid = $valid & $this->_sessionUser->is($role);
                }
                return $valid;
            }
        }

        protected function validatePerms()
        {
            if (is_null($this->_permissions)) {
                return true;
            } elseif (is_array($this->_permissions)) {
                $valid = true;
                foreach ($this->_permissions as $perm) {
                    $valid =& $this->_sessionUser->hasPermission($perm);
                }
                return $valid;
            }
        }

    }
}