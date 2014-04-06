<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 30/12/13
 * Time: 15:39
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Controllers;


use LibreMVC\Models\User;
use LibreMVC\Mvc\Controller\RestController;

class RestServiceController extends RestController {

    public $public = false;

    protected function isValidUser($user, $token){
        $user = \LibreMVC\Models\User::loadByPublicKey($user,$token);
        // Est un utilisateur connus.
        if( !is_null($user) ) {
            return true;
        }
        else {
            return false;
        }

    }

    public function post() {
        //echo __METHOD__;
        if($this->httpReply->valid) {
            var_dump( $_POST);
        }
    }

    public function put() {
        //echo __METHOD__;
        if($this->httpReply->valid) {
            var_dump( $_POST);
        }
    }

}