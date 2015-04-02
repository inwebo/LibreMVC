<?php
namespace LibreMVC\Controllers {

    use LibreMVC\Exception;
    use LibreMVC\Mvc\Controller\AuthController;
    use LibreMVC\Mvc\Controller\Traits\System;
    use LibreMVC\Http\Request;
    use LibreMVC\Mvc\Controller\UnauthorizedException;
    use LibreMVC\View;
    use LibreMVC\Modules\AuthUser\Models\AuthUser;
    use LibreMVC\System as SystemDataProvider;

    class PrivateController extends AuthController{

        use System;

        public function __construct( Request $request, View $view, AuthUser $authUser, SystemDataProvider $system ) {
            $this->_request = $request;
            $this->_view    = $view;
            $this->setAuthUser($authUser);
            $this->setSystem($system);
            $this->setRoles(array('Root'));
            $this->init();
        }

        public function getFile(){
            return __FILE__;
        }

        protected function init(){
            if($this->validateRequest()){
                //$this->changeLayout($this->_system->getModuleBaseDirs('admin','index'));
                //$viewsPath = $this->_system->this()->getModuleBaseDirs('admin','views') . $this->getViewPathFormat();
                //$this->changePartial('body',$viewsPath);
            }
            else {
                //header('HTTP/1.0 401 Unauthorized');
                //$viewsPath = $this->getSystem()->getModuleBaseDirs('error','static_views') .'error.php';
                //$this->changePartial('body',$viewsPath);
                throw new UnauthorizedException(UnauthorizedException::MSG,401);
            }
        }
    }
}