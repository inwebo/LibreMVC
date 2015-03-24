<?php

namespace LibreMVC\Modules\Error\Controllers {

    use LibreMVC\Mvc\Controller\StaticController;
    use LibreMVC\System;
    use LibreMVC\Http\Request;
    use LibreMVC\View;

    class ErrorController extends StaticController{

        /**
         * @var int HTTP status code
         */
        protected $_httpCode;

        const GET = '\\LibreMVC\\Modules\\Error\\Controllers\\ErrorController';

        public function __construct(Request $request, View $view, $baseDir, $httpCode) {
            parent::__construct($request, $view, $baseDir);
            $this->_baseDir = $baseDir;
        }

        public function init(){
            parent::init();
            //$viewsPath = System::this()->getModuleBaseDirs('error','static_views') . $this->getViewFileFormat();
            //$viewsPath = $this->_baseDir . 'error.php';
            //$this->changePartial('body',$viewsPath);
            $this->render();
        }
    }
}