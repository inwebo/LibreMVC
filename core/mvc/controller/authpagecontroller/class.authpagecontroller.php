<?php
/**
 * Created by PhpStorm.
 * User: inwebo
 * Date: 06/04/14
 * Time: 01:24
 */

namespace LibreMVC\Mvc\Controller;

use LibreMVC\Http\Header;
use LibreMVC\Mvc\Controller;
use LibreMVC\Sessions;

class AuthPageController extends Controller{

    /**
     * @var bool Test l'authentification sur toutes les actions AVANT leurs execution. Pratique pour les admins
     */
    protected $_public = true;

    /**
     * @var
     */
    protected $_user;

    /**
     * @var array Si vide tous les roles
     */
    //protected $_allowedRoles = array(4);
    protected $_allowedRoles = array();

    /**
     * @var array Si vide tous les droits
     */
    //protected $_allowedPerms = array(0);
    protected $_allowedPerms = array();

    public function init() {
        $this->_user = Sessions::get('User');
        if( !$this->_public ) {
            if( !$this->userHasRoles( $this->_allowedRoles ) ) {
                Header::forbidden();
                exit;
            }
            if( !$this->userHasPerms( $this->_allowedPerms ) ) {
                Header::forbidden();
                exit;
            }
        }
    }

    public function userHasRoles($idRoles) {
        if( !empty( $idRoles ) ) {
            foreach( $idRoles as $v ) {
                if( $this->_user->hasRole( $v ) ) {
                    return true;
                }
            }
            return false;
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