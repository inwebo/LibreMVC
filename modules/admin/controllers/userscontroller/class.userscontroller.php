<?php
/**
 * Created by PhpStorm.
 * User: inwebo
 * Date: 05/08/14
 * Time: 12:47
 */

namespace LibreMVC\Modules\Admin\Controllers;

use LibreMVC\Models\User;
use LibreMVC\Mvc\Controller\PageController;

class UsersController extends PageController{

    public function readAction(){
        $users = User::loadAll()->all();
        $this->toView("users", $users);
        $this->_view->render();
    }

} 