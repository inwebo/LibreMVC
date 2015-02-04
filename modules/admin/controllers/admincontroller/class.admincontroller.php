<?php
namespace LibreMVC\Modules\Admin\Controllers {

    use LibreMVC\Mvc\Controller\AuthController;

    abstract class AdminController extends AuthController{

        protected function init(){
            parent::init();
            $this->_roles = array('Root');
            if($this->validateRequest()){
                $this->changeLayout($this->_system->getModuleBaseDirs('admin','index'));
                $viewsPath = $this->_system->this()->getModuleBaseDirs('admin','views') . $this->getViewPathFormat();
                $this->changePartial('body',$viewsPath);
            }
            else {
                header('HTTP/1.0 401 Unauthorized');
                $viewsPath = $this->_system->this()->getModuleBaseDirs('error','static_views') .'error.php';
                $this->changePartial('body',$viewsPath);
            }
        }

    }
}