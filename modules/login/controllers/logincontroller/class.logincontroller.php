<?php

namespace LibreMVC\Modules\Login\Controllers {

    use LibreMVC\Http\Header;
    use LibreMVC\Mvc\Controller\BaseController;
    use LibreMVC\Session;
    use LibreMVC\Modules\AuthUser\Models\AuthUser;

    class LoginController extends BaseController {

        protected $_body;

        protected function init() {
            parent::init();
            // Change body
            var_dump($this->_system->getModule('login')->getStaticDir());
            var_dump($this->getControllerName());
            $viewsPath = $this->_system->this()->getModuleBaseDirs('login','static_views');
            $viewsPath = $viewsPath . 'login' . '.php';
            $this->changePartial('body',$viewsPath);
        }

        public function loginAction() {
            if( isset($_POST['user']) && isset($_POST['password']) ) {
                $user = filter_var($_POST['user'], FILTER_SANITIZE_STRING);
                $password = sha1(filter_var($_POST['password'], FILTER_SANITIZE_STRING));
                // Valid user ?
                $usr = $_SESSION['User']::loadByIdPwd($user,$password);
                if( !is_null($usr) ) {
                    $_SESSION['User'] = $usr;
                }
            }

            $this->render();
        }

        public function logoutAction() {
            session_destroy();
            $_SESSION = array();
            $_SESSION['User'] = $this->_system->defaultUser;
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }

    }
}