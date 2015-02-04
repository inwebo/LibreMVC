<?php

namespace LibreMVC\Modules\Error\Controllers {

    use LibreMVC\Mvc\Controller\StaticController;

    class ErrorController extends StaticController{

        const GET = '\\LibreMVC\\Modules\\Error\\Controllers\\ErrorController';

        public function init(){
            parent::init();
            $viewsPath = $this->_system->this()->getModuleBaseDirs('error','static_views') . $this->getViewFileFormat();
            $this->changePartial('body',$viewsPath);
        }

        public function __call( $name, $arguments ) {
            $this->render();
        }
    }
}