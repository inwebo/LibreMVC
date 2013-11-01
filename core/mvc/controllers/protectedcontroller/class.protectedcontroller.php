<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 01/11/13
 * Time: 18:54
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Mvc\Controllers;


use LibreMVC\Http\Header;
use LibreMVC\Mvc\Controllers\PageController;
use LibreMVC\Sessions;

class ProtectedController extends PageController{

    /**
     * @var array Si est vide tous les roles
     */
    protected $_authorizedRoles;

    /**
     * @var L'utilisateur courant
     */
    protected $_user;

    /**
     * Injection dépendance.
     */
    public function __construct() {
        parent::__construct();
        $this->_user = Sessions::get('User');
        $this->_authorizedRoles= array();
        $this->isForbidden();
    }

    protected function userIsRole() {
        // Test si User est bien du type attendu
        if( empty($this->_authorizedRoles) ) {
            return true;
        }
        $return = true;
        foreach( $this->_authorizedRoles as $v ) {
            $return &= $this->_user->hasRole( $v );
        }
        return $return;

    }

    protected function isForbidden() {
        if( !$this->userIsRole() ) {
            Header::forbidden();
        }
    }

}