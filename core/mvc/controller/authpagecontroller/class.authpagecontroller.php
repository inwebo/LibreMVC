<?php
/**
 * Created by PhpStorm.
 * User: inwebo
 * Date: 06/04/14
 * Time: 01:24
 */

namespace LibreMVC\Mvc\Controller;

use LibreMVC\Mvc\Controller;
use LibreMVC\Sessions;

class AuthPageController extends Controller{

    /**
     * @var bool Test l'authentification sur toutes les actions AVANT leurs execution. Pratique pour les admins
     */
    protected $_protectThis = true;

    protected $_user;
    /**
     * @var array Si vide tous les roles
     */
    protected $_allowedRoles = array();
    /**
     * @var array Si vide tous les droits
     */
    protected $_allowedPerms = array();

    public function init() {
        $this->_user = Sessions::get('User');
        if( $this->_protectThis ) {
            // Test automatique de l'auth par Role / Perms
            // Renvoit 404 si echec.
            
        }
    }

    public function userHasRoles($idRoles) {
        if( !empty( $idRoles ) ) {
            $allowed = true;
            foreach($idRoles as $v) {
                $allowed &= $this->_user->hasRole($v);
            }
            return $allowed;
        }
        else {
            return true;
        }
    }

    public function userHasPerms($idPerms) {
        if( !empty( $idPerms ) ) {
            $allowed = true;
            foreach($idPerms as $v) {
                $allowed &= $this->_user->hasPermission($v);
            }
            return $allowed;
        }
        else {
            return true;
        }
    }

} 