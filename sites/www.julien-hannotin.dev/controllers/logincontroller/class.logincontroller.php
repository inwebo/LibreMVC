<?php

namespace LibreMVC\Controllers;

use LibreMVC\Http\Header;
use LibreMVC\Instance;
use LibreMVC\Models\User;
use LibreMVC\Mvc\Controller\AuthPageController;
use LibreMVC\Database;
use LibreMVC\Mvc\Environnement;
use LibreMVC\Sessions;

class LoginController extends AuthPageController {
    public $_public = true;

    public function loginAction() {
        $user = filter_var($_POST['user'], FILTER_SANITIZE_STRING);
        $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
        //$validUser = User::isValidUser($user, sha1($password));

        if(User::isValidUser($user, sha1($password))) {
            $user =  User::load($user, 'login');
            Sessions::this()['User'] = $user;
            //@todo Ne fonctionne pas
            Sessions::set('User',$user);
            $_SESSION['User'] = $user;
            Header::redirect(Environnement::this()->instance->baseUrl);
        }
        else {
            Header::redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function logoutAction() {
        session_unset();
        session_destroy();
        Header::redirect($_SERVER['HTTP_REFERER']);
    }

}