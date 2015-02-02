<?php

namespace LibreMVC\Modules\Admin\Controllers {
    use LibreMVC\Modules\AuthUser\Models\AuthUser;
    use LibreMVC\System;
    use LibreMVC\Routing\RoutesCollection;

    class UserController extends AdminController {
        public function indexAction() {
            $driver = AuthUser::getBoundDriver();
            $this->render();
        }
    }
}