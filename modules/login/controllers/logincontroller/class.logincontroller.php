<?php

namespace LibreMVC\Modules\Login\Controllers;

use LibreMVC\Http\Header;
use LibreMVC\Instance;
use LibreMVC\Models\User;
use LibreMVC\Mvc\Controller\AuthPageController;
use LibreMVC\Database;
use LibreMVC\Mvc\Environnement;
use LibreMVC\Sessions;
use LibreMVC\View\Template;

class LoginController extends AuthPageController {
    public $_public = true;

    public function init() {
        Environnement::this()->templateAction = getcwd() . "/modules/login/views/tpl/form.php";
    }

    public function inAction() {
        $user = filter_var($_POST['user'], FILTER_SANITIZE_STRING);
        $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

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

    public function outAction() {
        session_unset();
        session_destroy();
        Header::redirect($_SERVER['HTTP_REFERER']);
    }

}