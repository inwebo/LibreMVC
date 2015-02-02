<?php

namespace LibreMVC\System\Boot\Tasks\Task {

    use LibreMVC\Models\User;
    use LibreMVC\Modules\AuthUser\Models\AuthUser;
    use LibreMVC\System\Boot\Tasks\Task;
    use LibreMVC\Session as AuthSession;


    class Session extends Task{

        static protected $_defaultUser;

        public function __construct(){
            parent::__construct();
            $this->_name ='Router';
        }

        protected function start() {
            AuthSession::init();
            parent::start();
        }

        protected function defaultUser() {
            $aUser = new AuthUser('guest','salut@copain.fr','','');
            $aUser = $aUser->hidden();
            self::$_defaultUser=$aUser;
            return $aUser;
        }

        protected function user() {
            if( !isset($_SESSION['User']) ) {
                $_SESSION['User'] = self::$_defaultUser;
            }
        }

        protected function end() {
            //unset($_SESSION);
            parent::end();
        }

    }
}