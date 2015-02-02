<?php

namespace LibreMVC\Modules\Admin\Controllers {
    use LibreMVC\Modules\AuthUser\Models\AuthUser;
    use LibreMVC\System;
    use LibreMVC\Routing\RoutesCollection;

    class UsersController extends AdminController {
        public function indexAction() {
            $driver = AuthUser::getBoundDriver();
            $driver->toStdClass();
            $user = $driver->query("select id FROM Users")->all();
            $users = new \ArrayIterator();
            foreach($user as $u) {
                $users->append(AuthUser::load($u->id));
            }
            $users->rewind();
            $this->toView("users", $users);
            $this->render();
        }
    }
}