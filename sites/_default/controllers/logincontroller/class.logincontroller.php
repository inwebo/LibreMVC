<?php
/**
 * Created by JetBrains PhpStorm.
 * User: inwebo
 * Date: 11/11/13
 * Time: 00:56
 * To change this template use File | Settings | File Templates.
 */

namespace LibreMVC\Controllers;

use LibreMVC\Http\Context;
use LibreMVC\Http\Header;
use LibreMVC\Instance;
use LibreMVC\Models\User;
use LibreMVC\Mvc\Controllers\PageController;
use LibreMVC\Mvc\Controllers\RestController;
use LibreMVC\Database;
use LibreMVC\Sessions;

class LoginController extends PageController{

    public function __construct(){
        parent::__construct();
    }

    public function indexAction($args) {
        $user = filter_var($_POST['user'], FILTER_SANITIZE_STRING);
        $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
        $validUser = User::isValidUser($user, $password,true);

        if($validUser instanceof User) {
            Sessions::this()['User'] = $validUser;
            //@todo Ne fonctionne pas
            Sessions::set('User',$validUser);
            $_SESSION['User'] = $validUser;
            Header::redirect(Instance::current()->baseUrl);
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