<?php

namespace LibreMVC\Modules\Error\Controllers;

use LibreMVC\Mvc\Controller\StaticController;
use LibreMVC\View;
class ErrorController extends StaticController{

    const GET = '\\LibreMVC\\Modules\\Error\\Controllers\\ErrorController';

    public function init(){
        parent::init();
    }

    public function __call( $name, $arguments ) {
        $this->_staticView  = $this->_staticView . $name.'.php';
        $viewObject = $this->_view->getViewObject();
        try{
            //$viewObject->attachPartial('body', View::partialsFactory( $this->_staticView, $viewObject ));
            $this->_view->attachPartial('body',$this->_staticView);
            $this->_view->render();
        }
        catch(\Exception $e) {
            var_dump($e);
        }
    }
}